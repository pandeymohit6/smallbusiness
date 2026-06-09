@extends('frontend.layouts.app')

 @section('content')
     <div class="hero-section">
         <h1 class="hero-title">Why Not Register with SmallBusinessesForSale.com?</h1>
         <p class="hero-subtitle">Join our 900,000 buyers taking advantage of our extensive features!</p>
     </div>

     <section class="buyer-reg">
         <div class="pricing-container">
             <div class="price-card">
                 <div>
                     <div class="plan-name">Standard</div>
                     <div class="price-amount">FREE</div>
                     <div class="price-subtext" style="margin-bottom: 35px;">No strings attached</div>
                     <a href="#standard-features" class="benefits-link">Benefits & Features</a>
                 </div>
                 <a href="{{route('buyer.registration.select.login')}}" class="btn-register">Register</a>
             </div>

             <!-- Premium Card -->
             <div class="price-card premium">
                 <div class="badge-premium">★ Premium</div>
                 <div>
                     <div class="plan-name">Premium</div>
                     <div>
                         <span class="price-amount">$14.95</span> <span class="price-currency">USD</span>
                         <div class="price-subtext">per month</div>
                     </div>

                     <div class="price-or">OR</div>
                     <div>
                         <div class="off-badge">50% OFF</div>
                         <div>
                             <span class="price-amount">$89.95</span> <span class="price-currency">USD</span>
                         </div>
                         <div class="price-subtext">per year</div>
                     </div>

                     <a href="#premium-features" class="benefits-link">Benefits & Features</a>
                 </div>
                 <a href="{{route('buyer.registration.select.login')}}" class="btn-register">Register</a>
             </div>

         </div>


         <!-- 2. Standard Buyer Features Section -->
         <div class="section-container" id="standard-features">
             <div class="section-header">
                 <h2 class="section-title">Standard Buyer</h2>
             </div>

             <div class="features-grid">

                 <!-- Feature 1 -->
                 <div class="feature-card">
                     <div class="icon-box standard-color">
                         <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM5 10h10M5 14h10M5 6h6"></path>
                         </svg>
                     </div>
                     <div class="feature-text-wrapper">
                         <h3>Saved Searches</h3>
                         <p>Save your preferred search terms and configurations for quick access anytime.</p>
                     </div>
                 </div>

                 <!-- Feature 2 -->
                 <div class="feature-card">
                     <div class="icon-box standard-color">
                         <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                             </path>
                         </svg>
                     </div>
                     <div class="feature-text-wrapper">
                         <h3>Email Alerts</h3>
                         <p>Get instant or daily notifications directly in your inbox matching your search query.</p>
                     </div>
                 </div>

                 <!-- Feature 3 -->
                 <div class="feature-card">
                     <div class="icon-box standard-color">
                         <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.317-1.317a4.5 4.5 0 00-6.364 0z">
                             </path>
                         </svg>
                     </div>
                     <div class="feature-text-wrapper">
                         <h3>Save your favourite business</h3>
                         <p>Bookmark listings that look promising so you can easily review them later.</p>
                     </div>
                 </div>

                 <!-- Feature 4 -->
                 <div class="feature-card">
                     <div class="icon-box standard-color">
                         <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586A1 1 0 0113 3.414l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                             </path>
                         </svg>
                     </div>
                     <div class="feature-text-wrapper">
                         <h3>Save time with pre filled forms</h3>
                         <p>Your profile data is auto-filled to save effort when contacting brokers.</p>
                     </div>
                 </div>

                 <!-- Feature 5 -->
                 <div class="feature-card">
                     <div class="icon-box standard-color">
                         <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                             </path>
                         </svg>
                     </div>
                     <div class="feature-text-wrapper">
                         <h3>Track messages you send to sellers</h3>
                         <p>Keep a clear logs and history of communication inside your unified dashboard.</p>
                     </div>
                 </div>

             </div>
             <div class="middle-cta-block">
                 <h2>Register for FREE today!</h2>
                 <div class="inline-btn-container">
                     <a href="{{route('buyer.registration.select.login')}}" class="btn-register">Register</a>
                 </div>
             </div>
         </div>


         <!-- 3. Premium Buyer Features Section -->
         <div class="section-container" id="premium-features" style="margin-top: 40px;">
             <div class="section-header">
                 <h2 class="section-title">Premium Buyer</h2>
             </div>

             <p class="section-intro-text">
                 Premium buyers enjoy all the benefits of a <a href="#standard-features">standard buyer</a> plus:
             </p>

             <div class="features-grid">

                 <!-- Premium Feature 1 -->
                 <div class="feature-card">
                     <div class="icon-box premium-color">
                         <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M5 11l7-7 7 7M5 19l7-7 7 7"></path>
                         </svg>
                     </div>
                     <div class="feature-text-wrapper">
                         <h3>Prioritised inquiries in seller's inbox</h3>
                         <p>Stand out instantly. Your message lands directly at the top of the seller's queue.</p>
                     </div>
                 </div>

                 <!-- Premium Feature 2 -->
                 <div class="feature-card">
                     <div class="icon-box premium-color">
                         <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                             </path>
                         </svg>
                     </div>
                     <div class="feature-text-wrapper">
                         <h3>Get seller's contact details*</h3>
                         <p>Bypass delays with immediate access to direct phone lines or direct emails.</p>
                     </div>
                 </div>

                 <!-- Premium Feature 3 -->
                 <div class="feature-card">
                     <div class="icon-box premium-color">
                         <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                             </path>
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                             </path>
                         </svg>
                     </div>
                     <div class="feature-text-wrapper">
                         <h3>See who is selling their business privately</h3>
                         <p>Identify off-market and independent private sales before competitors do.</p>
                     </div>
                 </div>

                 <!-- Premium Feature 4 -->
                 <div class="feature-card">
                     <div class="icon-box premium-color">
                         <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                             </path>
                         </svg>
                     </div>
                     <div class="feature-text-wrapper">
                         <h3>Priority Customer Services support</h3>
                         <p>Skip the usual queues with 24/7 designated elite helpdesk response.</p>
                     </div>
                 </div>

             </div>

             <div class="bottom-pricing-banner">
                 <h2>Just <span class="highlight-price">$14.95 <span
                             style="font-size:14px; font-weight:600; color:#475569;">USD</span></span> per month or <span
                         class="highlight-price">$89.95 <span
                             style="font-size:14px; font-weight:600; color:#475569;">USD</span></span> per year!</h2>
                 <div class="inline-btn-container">
                     <a href="{{route('buyer.registration.select.login')}}" class="btn-register" style="padding: 0 40px; width: auto;">Register</a>
                 </div>
             </div>
         </div>

     </section>
     
 @endsection
