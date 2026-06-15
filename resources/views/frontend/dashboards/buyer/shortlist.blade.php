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
                         <h1 class="mb-2">Your Shortlist</h1>
                         <p class="text-muted">Businesses you've marked as favorites for later review.</p>
                     </div>

                     <div class="card shadow-sm border-0">
                         <div class="card-body">
                             <div class="text-center py-5">
                                 <i class="bi bi-heart" style="font-size: 3rem; color: #ccc;"></i>
                                 <p class="text-muted mt-3 mb-0">Your shortlist is empty. Start adding businesses to
                                     compare!</p>
                             </div>
                         </div>
                     </div>
               </div>
             </div>
         </div>
     </section>
 @endsection

