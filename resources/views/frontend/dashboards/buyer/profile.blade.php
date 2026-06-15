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
                         <h1 class="mb-2">Your Profile</h1>
                         <p class="text-muted">Manage your personal information and preferences.</p>
                     </div>

                     <div class="row">
                         <div class="col-md-8">
                             <div class="card shadow-sm border-0">
                                 <div class="card-header bg-white border-bottom">
                                     <h5 class="mb-0">Profile Information</h5>
                                 </div>
                                 <div class="card-body">
                                     <form>
                                         <div class="row mb-3">
                                             <div class="col-md-6">
                                                 <label class="form-label">First Name</label>
                                                 <input type="text" class="form-control"
                                                     value="{{ auth()->user()->first_name }}" disabled>
                                             </div>
                                             <div class="col-md-6">
                                                 <label class="form-label">Last Name</label>
                                                 <input type="text" class="form-control"
                                                     value="{{ auth()->user()->last_name }}" disabled>
                                             </div>
                                         </div>

                                         <div class="mb-3">
                                             <label class="form-label">Email Address</label>
                                             <input type="email" class="form-control" value="{{ auth()->user()->email }}"
                                                 disabled>
                                         </div>

                                         <div class="mb-3">
                                             <label class="form-label">Phone Number</label>
                                             <input type="tel" class="form-control" placeholder="Add your phone number">
                                         </div>

                                         <div class="mb-3">
                                             <label class="form-label">Country</label>
                                             <input type="text" class="form-control" placeholder="Select your country"
                                                 disabled>
                                         </div>

                                         <button type="button" class="btn btn-primary">Update Profile</button>
                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>
         </div>
             </div>
         </div>
     </section>
 @endsection

