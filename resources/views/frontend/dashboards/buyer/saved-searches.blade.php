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
                         <h1 class="mb-2">Saved Searches</h1>
                         <p class="text-muted">Manage your saved search criteria and get notifications for new matches.</p>
                     </div>

                     <div class="row mb-4">
                         <div class="col-md-12">
                             <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saveSearchModal">
                                 <i class="bi bi-plus-circle me-2"></i>Create New Search
                             </button>
                         </div>
                     </div>

                     <div class="card shadow-sm border-0">
                         <div class="card-body">
                             <div class="text-center py-5">
                                 <i class="bi bi-search" style="font-size: 3rem; color: #ccc;"></i>
                                 <p class="text-muted mt-3 mb-0">No saved searches yet. Create one to get started!</p>
                             </div>
                         </div>
                     </div>

                     <!-- Save Search Modal -->
                     <div class="modal fade" id="saveSearchModal" tabindex="-1">
                         <div class="modal-dialog">
                             <div class="modal-content">
                                 <div class="modal-header">
                                     <h5 class="modal-title">Create Saved Search</h5>
                                     <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                 </div>
                                 <div class="modal-body">
                                     <form>
                                         <div class="mb-3">
                                             <label class="form-label">Search Name</label>
                                             <input type="text" class="form-control"
                                                 placeholder="e.g., Tech Startups Under $500k">
                                         </div>
                                         <div class="mb-3">
                                             <label class="form-label">Industry</label>
                                             <select class="form-select">
                                                 <option>Any Industry</option>
                                                 <option>Technology</option>
                                                 <option>Retail</option>
                                                 <option>Services</option>
                                             </select>
                                         </div>
                                     </form>
                                 </div>
                                 <div class="modal-footer">
                                     <button type="button" class="btn btn-secondary"
                                         data-bs-dismiss="modal">Cancel</button>
                                     <button type="button" class="btn btn-primary">Save Search</button>
                                 </div>
                             </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
     </section>
 @endsection

