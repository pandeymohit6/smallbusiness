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
                         <h1 class="mb-2">Your Sent Inquiries</h1>
                         <p class="text-muted">Track all inquiries you've sent to business sellers.</p>
                     </div>

                     <div class="card shadow-sm border-0">
                         <div class="card-body">
                             <table class="table table-hover mb-0">
                                 <thead class="table-light">
                                     <tr>
                                         <th>Business Name</th>
                                         <th>Date Sent</th>
                                         <th>Status</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <tr>
                                         <td colspan="4" class="text-center py-5 text-muted">
                                             No inquiries sent yet.
                                         </td>
                                     </tr>
                                 </tbody>
                             </table>
                         </div>
                     </div>
                </div>
             </div>
         </div>
     </section>
 @endsection

