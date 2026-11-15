{{-- Map viewers in blog posts (OpenSeadragon zoom maps "*-mp", Leaflet maps): no right-click "Save image",
     no drag-out, no long-press save on phones. Screenshots can't be blocked; this only removes the easy ways. --}}
<style>
  [id$="-mp"], [id$="-mp"] *, .openseadragon-container, .openseadragon-container *, .leaflet-container img, img.mp-ph {
    -webkit-touch-callout: none; -webkit-user-select: none; user-select: none; -webkit-user-drag: none;
  }
</style>
<script>
(function () {
  var SEL = '[id$="-mp"], .openseadragon-container, .leaflet-container, img.mp-ph';
  function inMap(t) { return t && t.closest && t.closest(SEL); }
  ['contextmenu', 'dragstart'].forEach(function (ev) {
    document.addEventListener(ev, function (e) { if (inMap(e.target)) e.preventDefault(); }, true);
  });
})();
</script>
