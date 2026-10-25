{{--
    Shared Alpine state for the seller listing forms.

    Expects: $typeSchema (PropertyTypeSchema::forJs()), $L (PropertyListing|null)
--}}
@php
    $L     = $L ?? null;
    $draft = $draft ?? [];

    // Precedence: a failed submit's old() input, then an autosaved draft, then the
    // listing being edited.
    $pick = function (string $key, $fallback = null) use ($L, $draft) {
        if (old($key) !== null)           return old($key);
        if (array_key_exists($key, $draft)) return $draft[$key];
        return $L->{$key} ?? $fallback;
    };

    $initType  = $pick('property_type', 'flat');
    $initTrans = $L->transaction_type ?? 'sell';   // not seller-editable any more
    $initGroup = \App\Support\PropertyTypeSchema::groupOf($initType);
    $initUnit  = $pick('area_unit', \App\Support\PropertyTypeSchema::defaultUnit($initType));
    $initAmen  = $pick('amenities', []);
    $initDet   = $pick('details', null) ?? ($L->type_details ?? []);
    $initPOR   = (bool) $pick('price_on_request', false);
    $initPrice = $initPOR ? '' : $pick('price', '');
    // Sellers type lakhs; rupees stay the stored unit. 5 decimals keeps ₹1 precision so an
    // odd stored price round-trips exactly, and rtrim keeps 45 as "45", not "45.00000".
    $initLakh  = ($initPrice === '' || $initPrice === null || ! is_numeric($initPrice))
        ? ''
        : rtrim(rtrim(number_format($initPrice / 100000, 5, '.', ''), '0'), '.');
    $initSite  = (bool) $pick('is_site', false);

    // Server-side errors for the dynamically rendered details[] fields.
    $detailErrors = [];
    foreach ($errors->keys() as $key) {
        if (str_starts_with($key, 'details.')) {
            $detailErrors[substr($key, 8)] = $errors->first($key);
        }
    }
@endphp
<script>
window.LISTING_SCHEMA  = @json($typeSchema);
window.LISTING_INITIAL = {
    ptype:          @json($initType),
    pgroup:         @json($initGroup),
    ttype:          @json($initTrans),
    areaUnit:       @json($initUnit),
    amenities:      @json(array_values((array) $initAmen)),
    details:        @json((object) $initDet),
    priceOnRequest: @json($initPOR),
    priceLakh:      @json((string) $initLakh),
    isSite:         @json($initSite),
    detailErrors:   @json((object) $detailErrors),
};

/**
 * Everything type-sensitive in the form reads from here. `schema` is the exact same
 * structure the server validates against, so what the seller sees is what will be accepted.
 */
function listingTypeState() {
    const init = window.LISTING_INITIAL;

    return {
        schema:         window.LISTING_SCHEMA,
        ptype:          init.ptype,
        pgroup:         init.pgroup,
        ttype:          init.ttype,
        areaUnit:       init.areaUnit,
        amenities:      init.amenities.slice(),
        details:        Object.assign({}, init.details),
        priceOnRequest: init.priceOnRequest,
        priceLakh:      init.priceLakh,
        isSite:         init.isSite,
        detailErrors:   init.detailErrors,
        stepErrors:     [],

        /* ── Schema lookups ── */
        t() {
            return this.schema.types[this.ptype] || this.schema.types.flat;
        },
        typeLabel()  { return this.t().label; },
        typeIcon()   { return ({
            flat:'🏢', house:'🏠', villa:'🏡', farmhouse:'🌳',
            plot:'📐', agricultural_land:'🌾', industrial_land:'🏗',
            office:'🏛', shop:'🏪', commercial:'🏢', warehouse:'📦', pg:'🛏',
        })[this.ptype] || '🏠'; },
        areaLabel()  { return this.t().areaLabel; },
        titleLabel()       { return this.t().titleLabel; },
        titlePlaceholder() { return this.t().titlePlaceholder; },
        unitList()   { return this.t().units; },
        amenityList(){ return this.t().amenities; },
        allowSite()  { return !!this.t().allowSite; },
        has(field)   { return this.t().core.indexOf(field) !== -1; },
        hasAny(list) { return list.some(f => this.has(f)); },
        req(field)   { return this.t().required.indexOf(field) !== -1; },
        isLand()     { return ['plot','agricultural_land','industrial_land'].indexOf(this.ptype) !== -1; },
        isCommercial(){ return ['office','shop','commercial','warehouse','industrial_land'].indexOf(this.ptype) !== -1; },

        /** Picking a category selects the first type in it, so ptype is never stale. */
        setGroup(group) {
            if (this.pgroup === group) return;
            this.pgroup = group;

            const types = (this.schema.groups[group] || {}).types || [];
            if (types.length && types.indexOf(this.ptype) === -1) {
                this.ptype = types[0];
            }
        },

        groupTypes() { return (this.schema.groups[this.pgroup] || {}).types || []; },

        extras() {
            const list = (this.t().extras || []).slice();
            if (this.ttype === 'rent') {
                (this.schema.rentExtras || []).forEach(f => list.push(f));
            }
            return list;
        },

        detailError(key) { return this.detailErrors[key] || ''; },

        /**
         * A field carrying `show_if` only appears once its controlling field has the
         * required answer — the RERA number, for instance, once RERA Approved is Yes.
         */
        showExtra(f) {
            if (!f.show_if) return true;
            return this.details[f.show_if.key] === f.show_if.value;
        },

        /** The rupee figure the form actually posts, derived from the lakhs typed in. */
        get priceRupees() {
            const n = parseFloat(this.priceLakh);
            return (!n || n <= 0) ? '' : Math.round(n * 100000);
        },

        /** Readback under the field, so a missing or extra zero is obvious. */
        get priceWords() {
            const n = this.priceRupees;
            if (!n) return '';
            const rupees = '₹ ' + n.toLocaleString('en-IN');
            return n >= 10000000
                ? rupees + '  (' + (n / 10000000).toFixed(2).replace(/\.00$/, '') + ' Crore)'
                : rupees;
        },

        /**
         * When the seller switches type, drop anything that no longer applies so they
         * never submit a bedroom count on a piece of farmland.
         */
        initTypeWatchers() {
            // Clear any conditional field whose condition no longer holds, so a hidden
            // value can never be submitted.
            this.$watch('details', () => {
                this.extras().forEach(f => {
                    if (f.show_if && !this.showExtra(f) && this.details[f.key]) {
                        this.details[f.key] = '';
                    }
                });
            });

            this.$watch('ptype', () => {
                if (this.unitList().indexOf(this.areaUnit) === -1) {
                    this.areaUnit = this.unitList()[0];
                }
                const allowedAmenities = this.amenityList();
                this.amenities = this.amenities.filter(a => allowedAmenities.indexOf(a) !== -1);

                const allowedKeys = this.extras().map(f => f.key);
                Object.keys(this.details).forEach(k => {
                    if (allowedKeys.indexOf(k) === -1) delete this.details[k];
                });

                if (!this.allowSite()) this.isSite = false;

                // A plot project is a site by definition, so the inventory table is on by
                // default the moment the category is chosen.
                if (this.ptype === 'plot') this.isSite = true;

                const g = this.t().group;
                if (g && g !== this.pgroup) this.pgroup = g;

                this.stepErrors = [];
            });

        },

        /* ── Validation, mirroring the server rules ── */

        descriptionText() {
            if (window._quill) return window._quill.getText().trim();
            const el = document.getElementById('description-hidden');
            return el ? el.value.replace(/<[^>]*>/g, '').trim() : '';
        },

        fieldValue(name) {
            const el = document.querySelector('[name="' + name + '"]');
            return el ? String(el.value || '').trim() : '';
        },

        errorsForStep(step) {
            const e = [];

            if (step === 1) {
                const titleMin = this.t().titleMin || 10;
                if (this.fieldValue('title').length < titleMin)
                    e.push('Enter a ' + this.titleLabel().toLowerCase() + ' of at least ' + titleMin + ' characters.');
                if (!this.priceOnRequest) {
                    const p = parseFloat(this.priceLakh);
                    if (!p || p <= 0) e.push('Enter an expected price, or tick "Price on Request".');
                }
                const area = parseFloat(this.fieldValue('area'));
                if (!area || area <= 0) e.push('Enter the ' + this.areaLabel().toLowerCase() + '.');
            }

            if (step === 2) {
                if (!this.fieldValue('locality')) e.push('Enter the locality or area.');
                if (this.fieldValue('address').length < 10) e.push('Enter a fuller address so buyers can locate the property.');
            }

            if (step === 3) {
                const labels = {
                    bedrooms: 'bedrooms', bathrooms: this.isCommercial() ? 'washrooms' : 'bathrooms',
                    furnishing: 'furnishing status', floor_no: 'floor number', total_floors: 'total floors',
                };
                this.t().required.forEach(f => {
                    if (!this.fieldValue(f)) e.push('Select the ' + (labels[f] || f.replace(/_/g, ' ')) + '.');
                });
                this.extras().forEach(f => {
                    if (f.required && !this.details[f.key]) e.push('Enter ' + f.label.toLowerCase() + '.');
                });
                if (this.descriptionText().length < 30) e.push('Write at least 30 characters in the description.');
            }

            return e;
        },

        /** Validates a step; returns true when it is safe to move on. */
        checkStep(step) {
            this.stepErrors = this.errorsForStep(step);
            if (this.stepErrors.length) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return false;
            }
            return true;
        },

        /** For the edit form, which is one long page rather than a wizard. */
        checkAll() {
            this.stepErrors = [1, 2, 3].reduce((all, s) => all.concat(this.errorsForStep(s)), []);
            if (this.stepErrors.length) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return false;
            }
            return true;
        },
    };
}
</script>
