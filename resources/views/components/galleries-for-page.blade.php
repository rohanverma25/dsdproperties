@php
    $dsdGalleries = \App\Models\GalleryPageLink::where('page_url', $pageUrl)
        ->with('gallery.images')
        ->get()
        ->pluck('gallery')
        ->filter();
@endphp
@foreach($dsdGalleries as $dsdGallery)
    @include('components.gallery-section', ['gallery' => $dsdGallery])
@endforeach
