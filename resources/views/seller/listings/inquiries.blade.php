@extends('seller.layouts.app')
@section('title', 'Inquiries')
@section('page-title', 'Inquiries — ' . Str::limit($listing->title, 40))

@section('content')
<div style="margin-bottom:16px;">
    <a href="{{ route('seller.listings.index') }}" style="color:#008080;text-decoration:none;font-size:13px;">← Back to Listings</a>
</div>

<div class="sp-card">
    <div class="sp-card-header">
        <span class="sp-card-title">{{ $inquiries->total() }} Inquiries for this property</span>
    </div>

    @if($inquiries->isEmpty())
        <div style="padding:40px;text-align:center;color:#94a3b8;">
            <div style="font-size:36px;margin-bottom:8px;">💬</div>
            <div style="font-size:14px;font-weight:500;">No inquiries yet</div>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table class="sp-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inquiries as $inq)
                    <tr>
                        <td style="font-weight:600;">{{ $inq->name }}</td>
                        <td><a href="tel:{{ $inq->phone }}" style="color:#008080;text-decoration:none;">{{ $inq->phone }}</a></td>
                        <td>
                            @if($inq->email)
                                <a href="mailto:{{ $inq->email }}" style="color:#008080;text-decoration:none;">{{ $inq->email }}</a>
                            @else
                                <span style="color:#94a3b8;">—</span>
                            @endif
                        </td>
                        <td style="max-width:300px;font-size:13px;color:#475569;">{{ $inq->message ?: '—' }}</td>
                        <td style="font-size:12.5px;color:#64748b;white-space:nowrap;">{{ $inq->created_at->format('d M Y, g:i A') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($inquiries->hasPages())
        <div style="padding:16px 22px;border-top:1px solid #e2e8f0;">
            <div class="sp-pagination">
                @if($inquiries->onFirstPage()) <span>‹</span> @else <a href="{{ $inquiries->previousPageUrl() }}">‹</a> @endif
                @foreach($inquiries->getUrlRange(1, $inquiries->lastPage()) as $p => $url)
                    @if($p == $inquiries->currentPage()) <span class="active">{{ $p }}</span>
                    @else <a href="{{ $url }}">{{ $p }}</a> @endif
                @endforeach
                @if($inquiries->hasMorePages()) <a href="{{ $inquiries->nextPageUrl() }}">›</a> @else <span>›</span> @endif
            </div>
        </div>
        @endif
    @endif
</div>
@endsection
