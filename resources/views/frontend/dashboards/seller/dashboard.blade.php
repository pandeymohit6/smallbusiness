 @extends('frontend.layouts.app')

 @section('content')
     <section class="ad-flt">
         <div class="container">

             <div class="flr-main-container">

                 <div class="flr-sidebar" id="flrSidebarDrawer">
                     @include('frontend.components.sidebar')
                 </div>

                 <div class="flr-content-area">
                     @include('components.breadcrumbs', ['title' => 'Private Seller Dashboard'])

                     <!-- Header -->
                     <div class="seller-dashboard-header glass-effect">

                         <div>
                             <span class="dashboard-tag">
                                 Private Seller Account
                             </span>

                             <h5>
                                 Your Account's Private Seller Dashboard
                             </h5>

                             <p>
                                 Manage your listings, enquiries and promotional services from one place.
                             </p>
                         </div>
                         <div>
                             <a href="{{ empty($countryCode) ? route('sell.business') : route('seller.createadvert', ['code' => $countryCode]) }}"
                                 class="btn-create-listing">
                                 <i class="fas fa-plus-circle"></i>
                                 Create New Listing
                             </a>
                         </div>

                     </div>

                     <!-- Stats -->
                     <div class="row g-4 mb-5">

                         <div class="col-md-3">
                             <div class="stat-card blue">
                                 <i class="fas fa-store"></i>
                                 <h3>{{ count($activeListings) }}</h3>
                                 <p>Active Listings</p>
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="stat-card green">
                                 <i class="fas fa-envelope"></i>
                                 <h3>18</h3>
                                 <p>Buyer Enquiries</p>
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="stat-card orange">
                                 <i class="fas fa-eye"></i>
                                 <h3>256</h3>
                                 <p>Listing Views</p>
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="stat-card purple">
                                 <i class="fas fa-star"></i>
                                 <h3>12</h3>
                                 <p>Saved Listings</p>
                             </div>
                         </div>

                     </div>
                     <div class="row mb-4">

                         <div class="col-md-8">
                             <div class="mini-card">
                                 <h6>Profile Completion</h6>

                                 <div class="progress mt-2" style="height:8px;">
                                     <div class="progress-bar bg-success" style="width:{{ $profileCompletion }}%">
                                     </div>
                                 </div>

                                 <small>
                                     {{ $profileCompletion }}% completed
                                 </small>
                             </div>
                         </div>

                         <div class="col-md-4">
                             <div class="mini-card text-center">
                                 <h6>Account Status</h6>
                                 <span class="badge bg-success">
                                     {{ auth()->user()->is_verified ? 'Verified Seller' : 'Pending Verification' }}
                                 </span>
                             </div>
                         </div>

                     </div>

                     <div class="incomplete-card">

                         <div class="warning-icon">
                             <i class="fas fa-exclamation-circle"></i>
                         </div>

                         <div class="listing-content">

                             <div class="listing-badge">
                                 Incomplete Listing
                             </div>

                             <h3 class="listing-title">
                                 {{ $incompleteListing->title ?? 'Untitled Business' }}
                             </h3>

                             <p class="listing-description">
                                 You started creating this business listing on
                                 <strong>{{ optional($incompleteListing)->created_at?->format('d M Y \a\t h:i A') }}</strong>
                                 but haven't completed it yet.
                             </p>

                             <div class="listing-note">
                                 <i class="fas fa-info-circle"></i>
                                 Complete your listing to start receiving enquiries from buyers.
                             </div>

                         </div>

                         @if ($incompleteListing)
                             <div class="listing-actions">

                                 <a href="{{ route('seller.createadvert', [
                                     'code' => $countryCode,
                                     'business' => $incompleteListing->uuid,
                                 ]) }}"
                                     class="btn-complete">

                                     <i class="fas fa-pen-to-square"></i>
                                     Complete Listing
                                 </a>

                                 <a href="#" class="btn-delete"
                                     onclick="return confirm('Are you sure you want to delete this listing?')">

                                     <i class="fas fa-trash-alt"></i>
                                     Delete
                                 </a>

                             </div>
                         @endif

                     </div>

                     <div class="dashboard-card mb-4">
                         <div class="card-header-custom">
                             <h5>
                                 <i class="fas fa-store me-2"></i>
                                 Active Listings
                             </h5>
                         </div>

                         <div class="table-responsive">
                             <table class="table listing-table align-middle mb-0">
                                 <thead>
                                     <tr>
                                         <th>Listing</th>
                                         <th>ID</th>
                                         <th>Status</th>
                                         <th>Views</th>
                                         <th>Enquiries</th>
                                         <th>Created</th>
                                         <th width="180">Action</th>
                                     </tr>
                                 </thead>

                                 <tbody>

                                     @forelse($activeListings as $business)
                                         <tr>

                                             <td>
                                                 <div>
                                                     <strong>
                                                         {{ $business->title }}
                                                     </strong>

                                                     <div class="small text-muted">
                                                         {{ $business->category->name ?? '-' }}
                                                     </div>
                                                 </div>
                                             </td>

                                             <td>
                                                 #{{ $business->reference_id }}
                                             </td>

                                             <td>

                                                 @if ($business->status == 'active')
                                                     <span class="badge bg-success">
                                                         Active
                                                     </span>
                                                 @elseif($business->status == 'draft')
                                                     <span class="badge bg-warning">
                                                         Draft
                                                     </span>
                                                 @else
                                                     <span class="badge bg-secondary">
                                                         {{ ucfirst($business->status) }}
                                                     </span>
                                                 @endif

                                             </td>

                                             <td>
                                                 {{ $business->views_count ?? 0 }}
                                             </td>

                                             <td>
                                                 {{ $business->enquiries_count ?? 0 }}
                                             </td>

                                             <td>
                                                 {{ $business->created_at->format('d M Y') }}
                                             </td>

                                             <td>

                                                 <div class="d-flex gap-2">

                                                     <a href="{{ route('business.details', $business->slug) }}"
                                                         class="btn btn-sm btn-primary">
                                                         View
                                                     </a>

                                                     <a href="{{ route('seller.createadvert', [
                                                         'code' => $countryCode,
                                                         'business' => $business->uuid,
                                                     ]) }}"
                                                         class="btn btn-sm btn-outline-secondary">
                                                         Edit
                                                     </a>

                                                 </div>

                                             </td>

                                         </tr>

                                     @empty

                                         <tr>
                                             <td colspan="7" class="text-center py-4">
                                                 No listings found.
                                             </td>
                                         </tr>
                                     @endforelse

                                 </tbody>
                             </table>
                         </div>
                     </div>

                     <div class="dashboard-card exposure-card">

                         <div class="card-header-custom">
                             <h5>
                                 <i class="fas fa-bullhorn me-2"></i>
                                 Give Your Listing More Exposure
                             </h5>
                         </div>

                         <p class="text-muted mb-4">
                             Reach more buyers and increase enquiries using our premium promotional services.
                         </p>

                         <div class="row g-3">

                             @foreach ($promotions as $promotion)
                                 <div class="col-md-3">
                                     <div class="mini-service-card">

                                         <i class="fas {{ $promotion['icon'] }}"></i>

                                         <h6>
                                             {{ $promotion['title'] }}
                                         </h6>

                                         <small>
                                             {{ $promotion['description'] }}
                                         </small>

                                     </div>
                                 </div>
                             @endforeach

                         </div>
                         <div class="row g-3" style="padding: inherit; margin-top: 15px;">
                             <h6>Need Pricing Information?</h6>
                             <p class="text-muted mb-4">
                                 For pricing information and to find out more about our marketing services please <a
                                     href="{{ route('contact') }}">
                                     Contact Us
                                 </a>
                             </p>
                         </div>
                     </div>

                 </div>
             </div>
         </div>
     </section>
 @endsection
