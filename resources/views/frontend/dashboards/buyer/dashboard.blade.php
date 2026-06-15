 @extends('frontend.layouts.app')

 @section('content')
     <section class="ad-flt">
         <div class="container">

             <div class="flr-main-container">

                 <div class="flr-sidebar" id="flrSidebarDrawer">
                     @include('frontend.components.sidebar')
                 </div>

                 <div class="flr-content-area">
                     <div class="dashboard-welcome">
                         <h1 class="mb-4">Welcome, {{ auth()->user()->first_name }}! 👋</h1>

                         <div class="row mb-5">
                             <div class="col-md-4 mb-3">
                                 <div class="card shadow-sm border-0 h-100">
                                     <div class="card-body">
                                         <div class="d-flex align-items-center">
                                             <div class="feature-icon bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                                 <i class="bi bi-envelope text-primary" style="font-size: 1.5rem;"></i>
                                             </div>
                                             <div>
                                                 <h6 class="card-title mb-1">Sent Inquiries</h6>
                                                 <p class="text-muted mb-0 small">0 inquiries</p>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-md-4 mb-3">
                                 <div class="card shadow-sm border-0 h-100">
                                     <div class="card-body">
                                         <div class="d-flex align-items-center">
                                             <div class="feature-icon bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                                 <i class="bi bi-search text-success" style="font-size: 1.5rem;"></i>
                                             </div>
                                             <div>
                                                 <h6 class="card-title mb-1">Saved Searches</h6>
                                                 <p class="text-muted mb-0 small">0 searches</p>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-md-4 mb-3">
                                 <div class="card shadow-sm border-0 h-100">
                                     <div class="card-body">
                                         <div class="d-flex align-items-center">
                                             <div class="feature-icon bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                                                 <i class="bi bi-heart text-danger" style="font-size: 1.5rem;"></i>
                                             </div>
                                             <div>
                                                 <h6 class="card-title mb-1">Shortlisted</h6>
                                                 <p class="text-muted mb-0 small">0 businesses</p>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="card shadow-sm border-0">
                             <div class="card-header bg-white border-bottom">
                                 <h5 class="mb-0">Recent Activity</h5>
                             </div>
                             <div class="card-body">
                                 <p class="text-muted mb-0">No recent activity. Start browsing businesses to get started!
                                 </p>
                             </div>
                         </div>
                     </div>
              </div>
             </div>
         </div>
     </section>
 @endsection

