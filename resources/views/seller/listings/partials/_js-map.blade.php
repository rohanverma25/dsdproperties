{{-- Google Maps location picker, shared by create and edit. --}}
<script>
/* ── Seller map picker ── */
var _gmapsLoaded = false, _sellerMap, _sellerMarker, _mapAutocomplete;

function initPropertyMap() {
    _gmapsLoaded = true;
    // The edit form shows the map straight away; the create wizard only on step 2, where
    // the container is still hidden and would produce a zero-size map.
    var el = document.getElementById('sellerMap');
    if (el && el.offsetParent !== null) onMapStepVisible();
}

function onMapStepVisible() {
    if (!_gmapsLoaded || !window.google) return;
    if (_sellerMap) { google.maps.event.trigger(_sellerMap, 'resize'); return; }

    var lucknow  = { lat: 26.8467, lng: 80.9462 };
    var savedLat = parseFloat(document.getElementById('propLat').value);
    var savedLng = parseFloat(document.getElementById('propLng').value);
    var hasPin   = !isNaN(savedLat) && !isNaN(savedLng);
    var center   = hasPin ? { lat: savedLat, lng: savedLng } : lucknow;

    _sellerMap = new google.maps.Map(document.getElementById('sellerMap'), {
        center: center, zoom: hasPin ? 17 : 13,
        mapTypeControl: false, streetViewControl: false, fullscreenControl: false,
    });

    _sellerMarker = new google.maps.Marker({
        map: _sellerMap, draggable: true, visible: hasPin,
        position: center, animation: google.maps.Animation.DROP,
        title: 'Drag to adjust property location',
    });

    _sellerMap.addListener('click', function(e) {
        _sellerMarker.setPosition(e.latLng);
        _sellerMarker.setVisible(true);
        _setPin(e.latLng.lat(), e.latLng.lng());
    });
    _sellerMarker.addListener('dragend', function(e) {
        _setPin(e.latLng.lat(), e.latLng.lng());
    });

    /* Places autocomplete on the search box */
    var searchEl = document.getElementById('mapSearchInput');
    if (searchEl && google.maps.places) {
        _mapAutocomplete = new google.maps.places.Autocomplete(searchEl, {
            bounds: new google.maps.LatLngBounds(
                new google.maps.LatLng(26.70, 80.80),
                new google.maps.LatLng(27.05, 81.12)
            ),
            strictBounds: false,
            componentRestrictions: { country: 'in' },
        });
        _mapAutocomplete.addListener('place_changed', function() {
            var place = _mapAutocomplete.getPlace();
            if (!place.geometry) return;
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            _sellerMap.setCenter({ lat: lat, lng: lng });
            _sellerMap.setZoom(17);
            _sellerMarker.setPosition({ lat: lat, lng: lng });
            _sellerMarker.setVisible(true);
            _setPin(lat, lng);
            searchEl.value = '';
        });
    }

    if (hasPin) _setPin(savedLat, savedLng);
}

function _setPin(lat, lng) {
    document.getElementById('propLat').value = lat.toFixed(7);
    document.getElementById('propLng').value = lng.toFixed(7);
    var d = document.getElementById('mapCoordsDisplay');
    if (d) d.textContent = 'Pinned: ' + lat.toFixed(5) + ', ' + lng.toFixed(5);
    var b = document.getElementById('clearPinBtn');
    if (b) b.style.display = 'inline';
}

function clearMapPin() {
    document.getElementById('propLat').value = '';
    document.getElementById('propLng').value = '';
    var d = document.getElementById('mapCoordsDisplay');
    if (d) d.textContent = '';
    var b = document.getElementById('clearPinBtn');
    if (b) b.style.display = 'none';
    if (_sellerMarker) _sellerMarker.setVisible(false);
}
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIrA0YRspz_UGlpWuNR1_LXX_8DfHWdj4&libraries=places&callback=initPropertyMap">
</script>
