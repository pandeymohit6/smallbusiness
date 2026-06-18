 @extends('frontend.layouts.app')

 @section('content')
     <section class="ad-flt">
         <div class="container">

             <div class="flr-main-container">

                 <div class="flr-sidebar" id="flrSidebarDrawer">
                     @include('frontend.components.sidebar')
                 </div>

                 <div class="flr-content-area">
                     @php
                         $breadcrumbs = [
                             'title' => 'Resources',
                             'icon' => 'lucide:book-open',
                             'back_url' => route('seller.dashboard'),
                             'items' => [
                                 [
                                     'label' => 'Dashboard',
                                     'url' => route('seller.dashboard'),
                                 ],
                                 [
                                     'label' => 'Resources',
                                 ],
                             ],
                         ];
                     @endphp
                     @include('components.breadcrumb', compact('breadcrumbs'))
                     <div class="resources-grid">

                         <a href="#" class="resource-box resource-box-1">
                             <h3>
                                 Listing<br>
                                 Optimisation<br>
                                 Guide
                             </h3>

                             <div class="resource-icon">
                                 <i class="fas fa-file-pdf"></i>
                             </div>
                         </a>

                         <a href="#" class="resource-box resource-box-2">
                             <h3>
                                 Stay safe. Spot<br>
                                 the signs.
                             </h3>
                         </a>

                         <a href="#" class="resource-box resource-box-3">
                             <h3>
                                 Frequently Asked<br>
                                 Questions
                             </h3>
                         </a>

                     </div>

                     <hr class="my-4">

                     <div class="broker-banner">

                         <div class="broker-icon">
                             <i class="fas fa-briefcase"></i>
                         </div>

                         <div class="broker-content">
                             <h3>Find a business broker</h3>

                             <p>
                                 For no charge or obligation, our referral service will
                                 match you with a professional broker who can help sell
                                 your business.
                             </p>

                             <a href="{{ route('seller.broker') }}" class="broker-btn">
                                 I'm interested
                             </a>
                         </div>

                     </div>
                 </div>
             </div>
         </div>
     </section>
 @endsection
