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
                         <h1 class="mb-2">Value My Business</h1>
                         <p class="text-muted">Get an estimate of your business value with our valuation tool.</p>
                     </div>

                     <div class="row">
                         <div class="col-md-8">
                             <div class="card shadow-sm border-0">
                                 <div class="card-header bg-white border-bottom">
                                     <h5 class="mb-0">Business Valuation Calculator</h5>
                                 </div>
                                 <div class="card-body">
                                     <form>
                                         <h6 class="mb-3 fw-bold">Business Information</h6>

                                         <div class="row mb-3">
                                             <div class="col-md-6">
                                                 <label class="form-label">Annual Revenue</label>
                                                 <div class="input-group">
                                                     <span class="input-group-text">$</span>
                                                     <input type="number" class="form-control" placeholder="0.00">
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <label class="form-label">Annual Profit/EBITDA</label>
                                                 <div class="input-group">
                                                     <span class="input-group-text">$</span>
                                                     <input type="number" class="form-control" placeholder="0.00">
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="mb-3">
                                             <label class="form-label">Business Type</label>
                                             <select class="form-select">
                                                 <option>Select business type...</option>
                                                 <option>Retail</option>
                                                 <option>Services</option>
                                                 <option>Technology</option>
                                                 <option>E-Commerce</option>
                                                 <option>Manufacturing</option>
                                                 <option>Other</option>
                                             </select>
                                         </div>

                                         <div class="mb-3">
                                             <label class="form-label">Years in Business</label>
                                             <input type="number" class="form-control" placeholder="e.g., 5">
                                         </div>

                                         <div class="mb-3">
                                             <label class="form-label">Number of Employees</label>
                                             <input type="number" class="form-control" placeholder="e.g., 10">
                                         </div>

                                         <button type="button" class="btn btn-primary btn-lg">
                                             <i class="bi bi-calculator me-2"></i>Calculate Valuation
                                         </button>
                                     </form>
                                 </div>
                             </div>
                         </div>

                         <div class="col-md-4">
                             <div class="card bg-primary bg-opacity-10 border-0">
                                 <div class="card-body">
                                     <h6 class="card-title text-primary mb-3">💡 Valuation Tips</h6>
                                     <ul class="small text-muted list-unstyled">
                                         <li class="mb-2">✓ Valuations are typically based on revenue multiples (3-5x
                                             EBITDA)</li>
                                         <li class="mb-2">✓ Growth trends and profitability significantly impact value
                                         </li>
                                         <li class="mb-2">✓ Having organized financial records increases business value
                                         </li>
                                         <li class="mb-2">✓ Customer retention and recurring revenue are highly valued
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                     </div>
        </div>
             </div>
         </div>
     </section>
 @endsection

