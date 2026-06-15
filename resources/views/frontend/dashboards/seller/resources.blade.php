 @extends('frontend.layouts.app')

 @section('content')
     <section class="ad-flt">
         <div class="container">

             <div class="flr-main-container">

                 <div class="flr-sidebar" id="flrSidebarDrawer">
                     @include('frontend.components.sidebar')
                 </div>

                 <div class="flr-content-area">
                     <div class="page-header mb-4">
                         <h1 class="mb-2">Resources</h1>
                         <p class="text-muted">Guides, tools, and templates to help you sell your business successfully.</p>
                     </div>

                     <div class="row">
                         <div class="col-md-6 mb-4">
                             <div class="card shadow-sm border-0 h-100">
                                 <div class="card-body">
                                     <div class="d-flex align-items-start">
                                         <div class="feature-icon bg-primary bg-opacity-10 rounded p-3 me-3"
                                             style="min-width: 50px;">
                                             <i class="bi bi-file-pdf text-primary"></i>
                                         </div>
                                         <div>
                                             <h5 class="card-title">How to Prepare Your Business for Sale</h5>
                                             <p class="text-muted small mb-0">A comprehensive guide on preparation steps
                                                 before listing your business.</p>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-md-6 mb-4">
                             <div class="card shadow-sm border-0 h-100">
                                 <div class="card-body">
                                     <div class="d-flex align-items-start">
                                         <div class="feature-icon bg-success bg-opacity-10 rounded p-3 me-3"
                                             style="min-width: 50px;">
                                             <i class="bi bi-file-pdf text-success"></i>
                                         </div>
                                         <div>
                                             <h5 class="card-title">Setting the Right Asking Price</h5>
                                             <p class="text-muted small mb-0">Learn valuation techniques and pricing
                                                 strategies for maximum returns.</p>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-md-6 mb-4">
                             <div class="card shadow-sm border-0 h-100">
                                 <div class="card-body">
                                     <div class="d-flex align-items-start">
                                         <div class="feature-icon bg-info bg-opacity-10 rounded p-3 me-3"
                                             style="min-width: 50px;">
                                             <i class="bi bi-file-pdf text-info"></i>
                                         </div>
                                         <div>
                                             <h5 class="card-title">Marketing Your Business Listing</h5>
                                             <p class="text-muted small mb-0">Strategies to increase visibility and attract
                                                 qualified buyers.</p>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-md-6 mb-4">
                             <div class="card shadow-sm border-0 h-100">
                                 <div class="card-body">
                                     <div class="d-flex align-items-start">
                                         <div class="feature-icon bg-danger bg-opacity-10 rounded p-3 me-3"
                                             style="min-width: 50px;">
                                             <i class="bi bi-file-pdf text-danger"></i>
                                         </div>
                                         <div>
                                             <h5 class="card-title">Handling Due Diligence</h5>
                                             <p class="text-muted small mb-0">Essential documents and information buyers
                                                 will request during due diligence.</p>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
 @endsection
