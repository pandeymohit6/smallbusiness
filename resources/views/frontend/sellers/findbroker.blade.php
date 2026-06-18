 @extends('frontend.layouts.app')

 @section('content')
     <section class="ad-flt">
         <div class="container">

             <div class="flr-main-container">

                 <div class="flr-sidebar" id="flrSidebarDrawer">
                     @include('frontend.components.sidebar')
                 </div>

                 <div class="flr-content-area">
                     <section class="broker-page">

                         <div class="container">

                             <!-- Hero -->
                             <div class="broker-hero">

                                 <div class="hero-content">

                                     <h1>
                                         Find a Broker to Help
                                         Sell Your Business
                                     </h1>

                                     <p>
                                         Our broker referral service connects you with experienced
                                         business brokers who can help value, market and sell
                                         your business successfully.
                                     </p>

                                     <a href="#broker-form" class="btn-find-broker">
                                         Find a Broker Now
                                     </a>

                                 </div>

                                 <div class="hero-image">
                                     <i class="fas fa-handshake"></i>
                                 </div>

                             </div>

                             <!-- How It Works -->

                             <div class="section-title">
                                 <h2>How does it work?</h2>
                             </div>

                             <div class="steps-grid">

                                 <div class="step-card">
                                     <div class="step-number">1</div>
                                     <h5>Fill in your details</h5>
                                     <p>
                                         Tell us about yourself and your business.
                                     </p>
                                 </div>

                                 <div class="step-card">
                                     <div class="step-number">2</div>
                                     <h5>We Match You</h5>
                                     <p>
                                         We connect you with qualified brokers.
                                     </p>
                                 </div>

                                 <div class="step-card">
                                     <div class="step-number">3</div>
                                     <h5>Broker Contacts You</h5>
                                     <p>
                                         A broker will contact you directly.
                                     </p>
                                 </div>

                             </div>

                             <!-- Benefits -->

                             <div class="section-title mt-5">
                                 <h2>How can a broker help?</h2>
                             </div>

                             <div class="benefits-grid">

                                 <div class="benefit-item">
                                     <i class="fas fa-file-contract"></i>
                                     <span>Prepare sales memorandum</span>
                                 </div>

                                 <div class="benefit-item">
                                     <i class="fas fa-chart-line"></i>
                                     <span>Business valuation</span>
                                 </div>

                                 <div class="benefit-item">
                                     <i class="fas fa-user-check"></i>
                                     <span>Screen buyers</span>
                                 </div>

                                 <div class="benefit-item">
                                     <i class="fas fa-bullhorn"></i>
                                     <span>Confidential marketing</span>
                                 </div>

                                 <div class="benefit-item">
                                     <i class="fas fa-gavel"></i>
                                     <span>Negotiation support</span>
                                 </div>

                                 <div class="benefit-item">
                                     <i class="fas fa-shield-alt"></i>
                                     <span>Due diligence assistance</span>
                                 </div>

                             </div>

                             <!-- Form -->

                             <div id="broker-form" class="broker-form-card">

                                 <h2>Fill in the form below to find a broker</h2>

                                 <form method="POST" action="{{ route('broker.storebrokerRequest') }}"
                                     x-data="brokerForm()" @submit.prevent="submitForm">

                                     @csrf

                                     <div x-show="formError" x-transition class="alert alert-danger mb-4">
                                         <i class="fas fa-circle-exclamation me-2"></i>
                                         Please correct the errors below before submitting.
                                     </div>

                                     <div class="row">

                                         {{-- First Name --}}
                                         <div class="col-md-6 mb-3">
                                             <label class="form-label">
                                                 First Name <span class="text-danger">*</span>
                                             </label>

                                             <input type="text" name="first_name" x-model="form.first_name"
                                                 class="form-control" :class="{ 'is-invalid': errors.first_name }">

                                             <small x-show="errors.first_name" x-text="errors.first_name"
                                                 class="text-danger"></small>
                                         </div>

                                         {{-- Last Name --}}
                                         <div class="col-md-6 mb-3">
                                             <label class="form-label">
                                                 Last Name <span class="text-danger">*</span>
                                             </label>

                                             <input type="text" name="last_name" x-model="form.last_name"
                                                 class="form-control" :class="{ 'is-invalid': errors.last_name }">

                                             <small x-show="errors.last_name" x-text="errors.last_name"
                                                 class="text-danger"></small>
                                         </div>

                                         {{-- Role --}}
                                         <div class="col-md-6 mb-3">
                                             <label class="form-label">
                                                 Role <span class="text-danger">*</span>
                                             </label>

                                             <select name="role" x-model="form.role" class="form-select"
                                                 :class="{ 'is-invalid': errors.role }">

                                                 <option value="">Select Role</option>
                                                 <option value="Owner">Owner</option>
                                                 <option value="Director">Director</option>
                                                 <option value="Partner">Partner</option>
                                                 <option value="Manager">Manager</option>
                                             </select>

                                             <small x-show="errors.role" x-text="errors.role" class="text-danger"></small>
                                         </div>

                                         {{-- Telephone --}}
                                         <div class="col-md-6 mb-3">
                                             <label class="form-label">
                                                 Telephone <span class="text-danger">*</span>
                                             </label>

                                             <input type="text" name="telephone" x-model="form.telephone"
                                                 class="form-control" :class="{ 'is-invalid': errors.telephone }">

                                             <small x-show="errors.telephone" x-text="errors.telephone"
                                                 class="text-danger"></small>
                                         </div>

                                         {{-- Email --}}
                                         <div class="col-md-12 mb-3">
                                             <label class="form-label">
                                                 Email Address <span class="text-danger">*</span>
                                             </label>

                                             <input type="email" name="email" x-model="form.email" class="form-control"
                                                 :class="{ 'is-invalid': errors.email }">

                                             <small x-show="errors.email" x-text="errors.email" class="text-danger"></small>
                                         </div>

                                         {{-- Business Name --}}
                                         <div class="col-md-12 mb-3">
                                             <label class="form-label">
                                                 Business Name <span class="text-danger">*</span>
                                             </label>

                                             <input type="text" name="business_name" x-model="form.business_name"
                                                 class="form-control" :class="{ 'is-invalid': errors.business_name }">

                                             <small x-show="errors.business_name" x-text="errors.business_name"
                                                 class="text-danger"></small>
                                         </div>

                                         {{-- Country --}}
                                         <div class="col-md-6 mb-3">
                                             <label class="form-label">
                                                 Country <span class="text-danger">*</span>
                                             </label>

                                             <select name="country" x-model="form.country" class="form-select"
                                                 :class="{ 'is-invalid': errors.country }">

                                                 <option value="">Select Country</option>
                                                 <option value="Australia">Australia</option>
                                                 <option value="USA">USA</option>
                                                 <option value="Canada">Canada</option>
                                                 <option value="United Kingdom">United Kingdom</option>
                                             </select>

                                             <small x-show="errors.country" x-text="errors.country"
                                                 class="text-danger"></small>
                                         </div>

                                         {{-- State --}}
                                         <div class="col-md-6 mb-3">
                                             <label class="form-label">
                                                 State / Region <span class="text-danger">*</span>
                                             </label>

                                             <input type="text" name="state" x-model="form.state"
                                                 class="form-control" :class="{ 'is-invalid': errors.state }">

                                             <small x-show="errors.state" x-text="errors.state"
                                                 class="text-danger"></small>
                                         </div>

                                         {{-- Business Type --}}
                                         <div class="col-md-6 mb-3">
                                             <label class="form-label">
                                                 Business Type <span class="text-danger">*</span>
                                             </label>

                                             <select name="business_type" x-model="form.business_type"
                                                 class="form-select" :class="{ 'is-invalid': errors.business_type }">

                                                 <option value="">Select Business Type</option>
                                                 <option value="Retail">Retail</option>
                                                 <option value="Manufacturing">Manufacturing</option>
                                                 <option value="Restaurant">Restaurant</option>
                                                 <option value="Technology">Technology</option>
                                                 <option value="Services">Services</option>
                                             </select>

                                             <small x-show="errors.business_type" x-text="errors.business_type"
                                                 class="text-danger"></small>
                                         </div>

                                         {{-- Approx Value --}}
                                         <div class="col-md-6 mb-3">
                                             <label class="form-label">
                                                 Approximate Value <span class="text-danger">*</span>
                                             </label>

                                             <select name="approx_value" x-model="form.approx_value" class="form-select"
                                                 :class="{ 'is-invalid': errors.approx_value }">

                                                 <option value="">Select Value</option>
                                                 <option value="Under 100K">Under $100K</option>
                                                 <option value="100K-500K">$100K - $500K</option>
                                                 <option value="500K-1M">$500K - $1M</option>
                                                 <option value="1M-5M">$1M - $5M</option>
                                                 <option value="5M+">$5M+</option>
                                             </select>

                                             <small x-show="errors.approx_value" x-text="errors.approx_value"
                                                 class="text-danger"></small>
                                         </div>

                                         {{-- Annual Turnover --}}
                                         <div class="col-md-12 mb-4">
                                             <label class="form-label">
                                                 Annual Turnover <span class="text-danger">*</span>
                                             </label>

                                             <select name="annual_turnover" x-model="form.annual_turnover"
                                                 class="form-select" :class="{ 'is-invalid': errors.annual_turnover }">

                                                 <option value="">Select Turnover</option>
                                                 <option value="Under 100K">Under $100K</option>
                                                 <option value="100K-500K">$100K - $500K</option>
                                                 <option value="500K-1M">$500K - $1M</option>
                                                 <option value="1M-5M">$1M - $5M</option>
                                                 <option value="5M+">$5M+</option>
                                             </select>

                                             <small x-show="errors.annual_turnover" x-text="errors.annual_turnover"
                                                 class="text-danger"></small>
                                         </div>

                                     </div>

                                     <button type="submit" class="btn btn-primary btn-lg px-5" :disabled="loading">

                                         <span x-show="!loading">
                                             Submit Enquiry
                                         </span>

                                         <span x-show="loading">
                                             <i class="fas fa-spinner fa-spin"></i>
                                             Submitting...
                                         </span>
                                     </button>

                                 </form>

                                 <script>
                                     function brokerForm() {
                                         return {
                                             loading: false,
                                             formError: false,

                                             form: {
                                                 first_name: '',
                                                 last_name: '',
                                                 role: '',
                                                 telephone: '',
                                                 email: '',
                                                 business_name: '',
                                                 country: '',
                                                 state: '',
                                                 business_type: '',
                                                 approx_value: '',
                                                 annual_turnover: '',
                                             },

                                             errors: {},

                                             submitForm(event) {

                                                 this.errors = {};
                                                 this.formError = false;

                                                 if (!this.form.first_name) this.errors.first_name = 'First name is required';
                                                 if (!this.form.last_name) this.errors.last_name = 'Last name is required';
                                                 if (!this.form.role) this.errors.role = 'Role is required';
                                                 if (!this.form.telephone) this.errors.telephone = 'Telephone is required';
                                                 if (!this.form.email) this.errors.email = 'Email is required';
                                                 if (!this.form.business_name) this.errors.business_name = 'Business name is required';
                                                 if (!this.form.country) this.errors.country = 'Country is required';
                                                 if (!this.form.state) this.errors.state = 'State is required';
                                                 if (!this.form.business_type) this.errors.business_type = 'Business type is required';
                                                 if (!this.form.approx_value) this.errors.approx_value = 'Approximate value is required';
                                                 if (!this.form.annual_turnover) this.errors.annual_turnover = 'Annual turnover is required';

                                                 const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                                                 if (this.form.email && !emailRegex.test(this.form.email)) {
                                                     this.errors.email = 'Please enter a valid email address';
                                                 }

                                                 if (Object.keys(this.errors).length > 0) {
                                                     this.formError = true;
                                                     return;
                                                 }

                                                 this.loading = true;
                                                 event.target.submit();
                                             }
                                         }
                                     }
                                 </script>

                             </div>

                         </div>

                     </section>
                 </div>
             </div>
         </div>
     </section>
 @endsection
