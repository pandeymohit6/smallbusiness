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
                         <h1 class="mb-2">Account Settings</h1>
                         <p class="text-muted">Manage your account preferences and security settings.</p>
                     </div>

                     <div class="row">
                         <div class="col-md-8">
                             <div class="card shadow-sm border-0 mb-4">
                                 <div class="card-header bg-white border-bottom">
                                     <h5 class="mb-0">Change Password</h5>
                                 </div>
                                 <div class="card-body">
                                     <form>
                                         <div class="mb-3">
                                             <label class="form-label">Current Password</label>
                                             <input type="password" class="form-control">
                                         </div>

                                         <div class="mb-3">
                                             <label class="form-label">New Password</label>
                                             <input type="password" class="form-control">
                                         </div>

                                         <div class="mb-3">
                                             <label class="form-label">Confirm New Password</label>
                                             <input type="password" class="form-control">
                                         </div>

                                         <button type="button" class="btn btn-primary">Update Password</button>
                                     </form>
                                 </div>
                             </div>

                             <div class="card shadow-sm border-0 mb-4">
                                 <div class="card-header bg-white border-bottom">
                                     <h5 class="mb-0">Email Preferences</h5>
                                 </div>
                                 <div class="card-body">
                                     <div class="form-check mb-3">
                                         <input class="form-check-input" type="checkbox" id="inquiryNotifications" checked>
                                         <label class="form-check-label" for="inquiryNotifications">
                                             Receive email notifications for new inquiries
                                         </label>
                                     </div>

                                     <div class="form-check mb-3">
                                         <input class="form-check-input" type="checkbox" id="bulletinUpdates" checked>
                                         <label class="form-check-label" for="bulletinUpdates">
                                             Receive updates and platform announcements
                                         </label>
                                     </div>

                                     <div class="form-check mb-3">
                                         <input class="form-check-input" type="checkbox" id="newsletter">
                                         <label class="form-check-label" for="newsletter">
                                             Subscribe to seller newsletter
                                         </label>
                                     </div>

                                     <button type="button" class="btn btn-primary">Save Preferences</button>
                                 </div>
                             </div>

                             <div class="card shadow-sm border-0 bg-light border-danger">
                                 <div class="card-header bg-white border-bottom border-danger">
                                     <h5 class="mb-0 text-danger">Danger Zone</h5>
                                 </div>
                                 <div class="card-body">
                                     <p class="text-muted mb-3">Close your account and delete all associated data. This
                                         action cannot be undone.</p>
                                     <button type="button" class="btn btn-outline-danger">Delete Account</button>
                                 </div>
                             </div>
                         </div>
                     </div>
                </div>
             </div>
         </div>
     </section>
 @endsection

