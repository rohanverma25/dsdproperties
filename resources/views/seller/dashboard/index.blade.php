@extends('seller.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:16px;margin-bottom:28px;">
    @php
    $statCards = [
        ['label'=>'Total Listings',  'value'=>$stats['total'],     'icon'=>'🏠', 'color'=>'#011f4b'],
        ['label'=>'Published',       'value'=>$stats['published'], 'icon'=>'✅', 'color'=>'#16a34a'],
        ['label'=>'Under Review',    'value'=>$stats['pending'],   'icon'=>'⏳', 'color'=>'#ca8a04'],
        ['label'=>'Drafts',          'value'=>$stats['draft'],     'icon'=>'📝', 'color'=>'#64748b'],
        ['label'=>'Total Views',     'value'=>number_format($stats['views']), 'icon'=>'👁', 'color'=>'#008080'],
        ['label'=>'Inquiries',       'value'=>$stats['inquiries'], 'icon'=>'💬', 'color'=>'#FF5C00'],
    ];
    @endphp
    @foreach($statCards as $s)
    <div class="sp-card" style="padding:18px 20px;">
        <div style="font-size:22px;margin-bottom:6px;">{{ $s['icon'] }}</div>
        <div style="font-size:22px;font-weight:700;color:{{ $s['color'] }};">{{ $s['value'] }}</div>
        <div style="font-size:12px;color:#64748b;font-weight:500;margin-top:2px;">{{ $s['label'] }}</div>
    </div>
    @endforeach
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;">

    <div class="sp-card">
        <div class="sp-card-header">
            <span class="sp-card-title">Recent Listings</span>
            <a href="{{ route('seller.listings.index') }}" style="font-size:13px;color:#008080;text-decoration:none;">View all →</a>
        </div>
        <div style="overflow-x:auto;">
            @if($recentListings->isEmpty())
                <div style="padding:32px;text-align:center;color:#94a3b8;">
                    <div style="font-size:36px;margin-bottom:8px;">🏠</div>
                    <div style="font-size:14px;font-weight:500;margin-bottom:6px;">No listings yet</div>
                    <a href="{{ route('seller.listings.create') }}" class="sp-btn sp-btn-primary" style="margin-top:10px;">Post your first property</a>
                </div>
            @else
                <table class="sp-table">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentListings as $l)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    @if($l->featured_image && file_exists(public_path($l->featured_image)))
                                        <img src="{{ asset($l->featured_image) }}" style="width:48px;height:38px;border-radius:6px;object-fit:cover;" alt="">
                                    @elseif($l->images->first())
                                        <img src="{{ asset($l->images->first()->image_path) }}" style="width:48px;height:38px;border-radius:6px;object-fit:cover;" alt="">
                                    @else
                                        <div style="width:48px;height:38px;border-radius:6px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:18px;">🏠</div>
                                    @endif
                                    <div>
                                        <a href="{{ route('seller.listings.edit', $l) }}" style="font-weight:600;color:#011f4b;text-decoration:none;font-size:13px;">{{ Str::limit($l->title,40) }}</a>
                                        <div style="font-size:11.5px;color:#64748b;">{{ $l->locality }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:12.5px;">{{ $l->getTypeLabel() }}</td>
                            <td style="font-weight:600;font-size:13px;color:#011f4b;">{{ $l->getPriceDisplay() }}</td>
                            <td>
                                <span class="sp-badge sp-badge-{{ $l->status }}">{{ ucfirst($l->status) }}</span>
                            </td>
                            <td style="color:#64748b;">{{ number_format($l->views) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:16px;">
        <div class="sp-card sp-card-body">
            <div style="font-size:14px;font-weight:700;color:#011f4b;margin-bottom:14px;">Quick Actions</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <a href="{{ route('seller.listings.create') }}" class="sp-btn sp-btn-primary" style="justify-content:center;">
                    + Post New Property
                </a>
                <a href="{{ route('seller.listings.index') }}" class="sp-btn sp-btn-outline" style="justify-content:center;">
                    My Listings
                </a>
                <a href="{{ route('seller.profile') }}" class="sp-btn sp-btn-outline" style="justify-content:center;">
                    Edit Profile
                </a>
            </div>
        </div>

        <div class="sp-card sp-card-body">
            <div style="font-size:14px;font-weight:700;color:#011f4b;margin-bottom:12px;">Listing Status Guide</div>
            @foreach(['pending'=>['⏳','Under review — visible soon'],'published'=>['✅','Live — buyers can see it'],'draft'=>['📝','Saved, not submitted'],'rejected'=>['❌','Needs correction — edit & resubmit']] as $s=>$info)
            <div style="display:flex;align-items:flex-start;gap:8px;margin-bottom:10px;">
                <span class="sp-badge sp-badge-{{ $s }}" style="flex-shrink:0;">{{ ucfirst($s) }}</span>
                <span style="font-size:12px;color:#64748b;">{{ $info[1] }}</span>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
