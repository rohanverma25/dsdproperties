<style>
a.nav-link:hover {
    background-color: #495057;
    text-decoration: none;
}
.nav-link.active {
    border-radius: 6px;
}
.nav-link i { width: 18px; text-align: center; margin-right: 6px; }
</style>
<div class="bg-dark text-white vh-100" style="width:250px;">
<h5 class="p-3">Lead Admin</h5>
<ul class="nav flex-column px-2">

<li class="nav-item">
    <a class="nav-link text-white {{ request()->is('admin/crm*') ? 'active fw-bold bg-primary' : '' }}"
       href="{{ route('admin.crm.leads.index') }}">
        <i class="fa-solid fa-phone-volume"></i>Follow-ups
        @php $crmDue = \App\Models\CrmLead::dueToday()->count(); @endphp
        @if($crmDue > 0)
            <span class="badge bg-danger ms-1">{{ $crmDue }}</span>
        @endif
    </a>
</li>

<li class="nav-item">
    <a class="nav-link text-white {{ request()->is('admin/campaigns*') ? 'active fw-bold bg-primary' : '' }}"
       href="{{ url('admin/campaigns') }}">
        <i class="fa-solid fa-bullhorn"></i>Campaigns
    </a>
</li>

<li class="nav-item">
    <a class="nav-link text-white {{ request()->is('admin/templates*') ? 'active fw-bold bg-primary' : '' }}"
       href="{{ url('admin/templates/create') }}">
        <i class="fa-solid fa-envelope-open-text"></i>Email Templates
    </a>
</li>

<li class="nav-item">
    <a class="nav-link text-white {{ request()->is('admin/leads*') ? 'active fw-bold bg-primary' : '' }}"
       href="{{ url('admin/leads/upload') }}">
        <i class="fa-solid fa-file-import"></i>Import Leads
    </a>
</li>

<li class="nav-item">
    <a class="nav-link text-white {{ request()->is('admin/sellers*') ? 'active fw-bold bg-primary' : '' }}"
       href="{{ url('admin/sellers') }}">
        <i class="fa-solid fa-user-tie"></i>Sellers
        @php $sellerCount = \App\Models\Seller::count(); @endphp
        @if($sellerCount > 0)
            <span class="badge bg-info text-dark ms-1">{{ $sellerCount }}</span>
        @endif
    </a>
</li>
<li class="nav-item">
    <a class="nav-link text-white {{ request()->is('admin/properties*') ? 'active fw-bold bg-primary' : '' }}"
       href="{{ url('admin/properties') }}">
        <i class="fa-solid fa-building"></i>Properties
        @php $pendingCount = \App\Models\PropertyListing::where('status','pending')->count(); @endphp
        @if($pendingCount > 0)
            <span class="badge bg-warning text-dark ms-1">{{ $pendingCount }}</span>
        @endif
    </a>
</li>
<li class="nav-item">
    <a class="nav-link text-white {{ request()->is('admin/galleries*') ? 'active fw-bold bg-primary' : '' }}"
       href="{{ url('admin/galleries') }}">
        <i class="fa-solid fa-images"></i>Galleries
    </a>
</li>
<li class="nav-item">
    <a class="nav-link text-white {{ request()->is('blogseditor/*') ? 'active fw-bold bg-primary' : '' }}"
       href="{{ url('blogseditor') }}">
        <i class="fa-solid fa-newspaper"></i>Manage Blogs
    </a>
</li>
<li class="nav-item">
    <a class="nav-link text-white {{ request()->is('blogseditor/create') ? 'active fw-bold bg-primary' : '' }}"
       href="{{ url('blogseditor/create') }}">
        <i class="fa-solid fa-plus"></i>Add New Blog
    </a>
</li>
<li class="nav-item">
    <a class="nav-link text-white {{ request()->is('admin/reviews*') ? 'active fw-bold bg-primary' : '' }}"
       href="{{ url('admin/reviews') }}">
        <i class="fa-solid fa-star"></i>Google Reviews
        @php $reviewCount = \App\Models\GoogleReview::where('is_active', true)->count(); @endphp
        @if($reviewCount > 0)
            <span class="badge bg-success text-white ms-1">{{ $reviewCount }}</span>
        @endif
    </a>
</li>
<li class="nav-item">
    <a class="nav-link text-white {{ request()->is('admin/comments*') ? 'active fw-bold bg-primary' : '' }}"
       href="{{ url('admin/comments') }}">
        <i class="fa-solid fa-comments"></i>Comments
    </a>
</li>
<li class="nav-item">
    <a class="nav-link text-white {{ request()->is('admin/enquiries*') ? 'active fw-bold bg-primary' : '' }}"
       href="{{ url('admin/enquiries') }}">
        <i class="fa-solid fa-inbox"></i>Enquiries
        {{-- Unworked enquiries only: converted, spam and archived rows are done with.
             Newsletter sign-ups are not enquiries and are not counted. --}}
        @php
            $enquiryCount = \App\Models\FormSubmission::where('status', 'new')
                ->where('source_form', '!=', \App\Models\FormSubmission::FORM_NEWSLETTER)
                ->count();
        @endphp
        @if($enquiryCount > 0)
            <span class="badge bg-success text-white ms-1">{{ $enquiryCount }}</span>
        @endif
    </a>
</li>
</ul>
</div>
