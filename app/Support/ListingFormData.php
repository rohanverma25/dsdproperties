<?php

namespace App\Support;

use App\Models\PropertyListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidatorInstance;

/**
 * Builds the validation rules and the persisted payload for a seller listing, driven by
 * PropertyTypeSchema so every property type is validated by its own rules.
 *
 * Two things this fixes that a flat rule list could not:
 *  - a flat must declare bedrooms/bathrooms, a plot must not be asked for them at all;
 *  - fields that do not apply to the chosen type are written back as NULL, so switching
 *    a listing from Flat to Plot cannot leave "3 BHK" hanging on a piece of land.
 */
class ListingFormData
{
    /** Fields that are numeric counts on their own columns. */
    private const COUNT_LIMITS = [
        'bedrooms'     => 20,
        'bathrooms'    => 20,
        'balconies'    => 20,
        'floor_no'     => 200,
        'total_floors' => 200,
    ];

    /**
     * The site sells only, so the seller is never asked for a transaction type. An
     * existing rental listing keeps its own value when edited; anything new is a sale.
     */
    public static function transactionType(Request $request, ?PropertyListing $existing = null): string
    {
        return $existing->transaction_type ?? 'sell';
    }

    public static function validator(Request $request, bool $isUpdate = false, ?PropertyListing $existing = null): ValidatorInstance
    {
        $type   = (string) $request->input('property_type');
        $schema = PropertyTypeSchema::get($type);
        $trans  = self::transactionType($request, $existing);

        $rules = [
            'title'            => 'required|string|min:' . PropertyTypeSchema::titleMin($type) . '|max:255',
            'property_type'    => 'required|in:' . implode(',', PropertyTypeSchema::keys()),
            'transaction_type' => 'nullable|in:sell,rent',
            'price'            => 'nullable|integer|min:0|max:999999999999',
            'area'             => 'required|numeric|min:0.01|max:9999999',
            'area_unit'        => 'required|in:' . implode(',', array_keys(PropertyTypeSchema::unitsFor($type) ?: PropertyTypeSchema::AREA_UNITS)),
            'address'          => 'required|string|min:10|max:2000',
            'locality'         => 'required|string|max:255',
            'landmark'         => 'nullable|string|max:255',
            'pincode'          => 'nullable|digits:6',
            'description'      => 'required|string|min:30',
            'amenities'        => 'nullable|array',
            // Deliberately not an `in:` rule. An amenity that a type no longer offers (or
            // that is sitting in an autosaved draft) is dropped by columns() below rather
            // than failing the whole submit, which is how extras behave too.
            'amenities.*'      => 'string|max:100',
            'featured_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images'           => 'nullable|array|max:10',
            'images.*'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'video'            => 'nullable|mimes:mp4,mov,webm,avi|max:102400',
            'youtube_url'      => 'nullable|url|max:500',
            'brochure'         => 'nullable|mimes:pdf|max:10240',
            'plot_segments'    => 'nullable|string',
            'lat'              => 'nullable|numeric|between:-90,90',
            'lng'              => 'nullable|numeric|between:-180,180',
            'tags'             => 'nullable|array',
            'tags.*'           => 'integer|exists:tags,id',
            'details'          => 'nullable|array',
        ];

        // Price is required unless the seller explicitly chose "Price on Request".
        if (! $request->boolean('price_on_request')) {
            $rules['price'] = 'required|integer|min:1|max:999999999999';
        }

        // Core fields: only validated when the chosen type actually uses them.
        foreach (self::COUNT_LIMITS as $field => $max) {
            if (! $schema || ! in_array($field, $schema['core'], true)) {
                continue;
            }
            $required     = in_array($field, $schema['required'], true) ? 'required' : 'nullable';
            $min          = $field === 'bedrooms' || $field === 'balconies' || $field === 'floor_no' ? 0 : 1;
            $rules[$field] = "$required|integer|min:$min|max:$max";
        }

        if ($schema && in_array('furnishing', $schema['core'], true)) {
            $rules['furnishing'] = (in_array('furnishing', $schema['required'], true) ? 'required' : 'nullable')
                . '|in:' . implode(',', array_keys(PropertyListing::$furnishingLabels));
        }
        if ($schema && in_array('property_age', $schema['core'], true)) {
            $rules['property_age'] = 'nullable|in:' . implode(',', array_keys(PropertyListing::$ageLabels));
        }
        if ($schema && in_array('facing', $schema['core'], true)) {
            $rules['facing'] = 'nullable|in:' . implode(',', PropertyTypeSchema::FACINGS);
        }
        if ($schema && in_array('parking', $schema['core'], true)) {
            $rules['parking'] = 'nullable|in:' . implode(',', PropertyTypeSchema::PARKING);
        }

        // Type-specific extras, one rule per declared field.
        foreach (PropertyTypeSchema::extrasFor($type, $trans) as $field) {
            $key  = 'details.' . $field['key'];
            $base = ! empty($field['required']) ? 'required' : 'nullable';

            $rules[$key] = match ($field['type']) {
                'number' => "$base|numeric|min:0|max:99999999",
                'date'   => "$base|date",
                'select' => "$base|in:" . implode(',', $field['options'] ?? []),
                default  => "$base|string|max:255",
            };
        }

        $messages = [
            'title.min'       => 'Enter a ' . strtolower(PropertyTypeSchema::getOrDefault($type)['title_label'])
                . ' of at least ' . PropertyTypeSchema::titleMin($type) . ' characters.',
            'area.required'   => 'Please enter the ' . strtolower(PropertyTypeSchema::getOrDefault($type)['area_label']) . '.',
            'price.required'  => 'Enter a price, or tick "Price on Request".',
            'address.min'     => 'Please give a fuller address so buyers can find the property.',
            'description.min' => 'Write at least 30 characters describing the property.',
            'pincode.digits'  => 'Pincode must be 6 digits.',
            'images.max'      => 'You can upload up to 10 additional photos.',
        ];

        foreach (PropertyTypeSchema::extrasFor($type, $trans) as $field) {
            $messages['details.' . $field['key'] . '.in']       = 'Please choose a valid ' . strtolower($field['label']) . '.';
            $messages['details.' . $field['key'] . '.required'] = $field['label'] . ' is required for this property type.';
        }

        $v = Validator::make($request->all(), $rules, $messages);

        // A brand-new listing should carry at least one photo; an edit may already have some.
        if (! $isUpdate) {
            $v->after(function ($v) use ($request) {
                if (! $request->hasFile('featured_image') && ! $request->hasFile('images')) {
                    $v->errors()->add('featured_image', 'Please upload at least one photo of the property.');
                }
            });
        }

        return $v;
    }

    /**
     * The column payload. `null`s out every core field the chosen type does not use, so a
     * plot never carries a bedroom count and a flat never carries a soil type.
     */
    public static function columns(Request $request, ?PropertyListing $existing = null): array
    {
        $type   = (string) $request->input('property_type');
        $schema = PropertyTypeSchema::getOrDefault($type);
        $onReq  = $request->boolean('price_on_request');

        /**
         * A field the form no longer renders is absent from the request entirely, so keep
         * whatever is stored rather than wiping it. A field that IS on the form but left
         * blank posts an empty string, which still clears correctly. Landmark and pincode
         * were dropped from the location step but older listings still hold them.
         */
        $keepIfAbsent = function (string $key) use ($request, $existing) {
            if (! $request->has($key)) {
                return $existing->{$key} ?? null;
            }
            $value = $request->input($key);
            return ($value === '' || $value === null) ? null : $value;
        };

        $data = [
            'title'            => trim((string) $request->input('title')),
            'property_type'    => $type,
            'transaction_type' => self::transactionType($request, $existing),
            'price'            => $onReq ? 0 : (int) $request->input('price'),
            'price_negotiable' => $request->boolean('price_negotiable'),
            'price_on_request' => $onReq,
            'area'             => $request->input('area'),
            'area_unit'        => $request->input('area_unit'),
            'address'          => trim((string) $request->input('address')),
            'locality'         => trim((string) $request->input('locality')),
            'landmark'         => $keepIfAbsent('landmark'),
            'pincode'          => $keepIfAbsent('pincode'),
            'description'      => $request->input('description'),
            'amenities'        => self::amenities($request, $type),
            'is_site'          => $schema['allow_site'] && $request->boolean('is_site'),
            'type_details'     => self::details($request, $type),
            'lat'              => $request->filled('lat') ? (float) $request->input('lat') : null,
            'lng'              => $request->filled('lng') ? (float) $request->input('lng') : null,
        ];

        foreach (PropertyTypeSchema::CORE_OPTIONAL_FIELDS as $field) {
            if (! in_array($field, $schema['core'], true)) {
                $data[$field] = null;
                continue;
            }
            $value = $request->input($field);
            if (isset(self::COUNT_LIMITS[$field])) {
                $data[$field] = is_numeric($value) ? (int) $value : null;
            } else {
                $data[$field] = ($value === '' || $value === null) ? null : $value;
            }
        }

        // plot_segments only means anything for types that can be listed as a whole site.
        if (! $data['is_site']) {
            $data['plot_segments'] = null;
        } elseif ($request->filled('plot_segments')) {
            $decoded = json_decode((string) $request->input('plot_segments'), true);
            $data['plot_segments'] = is_array($decoded) ? $decoded : null;
        }

        return $data;
    }

    /** Keeps only amenities that belong to the chosen type's set. */
    private static function amenities(Request $request, string $type): array
    {
        $allowed = PropertyTypeSchema::amenitiesFor($type);
        return array_values(array_intersect((array) $request->input('amenities', []), $allowed));
    }

    /** Keeps only extras the chosen type declares, dropping blanks. */
    private static function details(Request $request, string $type): array
    {
        $allowed = PropertyTypeSchema::extraKeysFor($type);
        $out     = [];

        foreach ((array) $request->input('details', []) as $key => $value) {
            if (! in_array($key, $allowed, true)) continue;
            if ($value === null || $value === '' || $value === []) continue;
            $out[$key] = is_string($value) ? trim($value) : $value;
        }

        return $out;
    }
}
