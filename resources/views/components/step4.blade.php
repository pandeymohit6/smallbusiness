 <!-- Step 4: Final Confirmation -->
 <div id="tab-page-4" class="wizard-tab-list" :class="{ 'active-tab-list': currentStep === 5 }">
     <div class="confirmation-box-list" x-show="!loading">

         <!-- Draft Saved -->
         <template x-if="formData.status === 'draft'">
             <div>
                 <h2 style="color:#f39c12;">📝 Draft Saved Successfully</h2>

                 <p class="intro-text-list" style="background:#fff8e6;border-left-color:#f39c12;color:#444;">
                     Your business listing has been saved as a draft.
                     You can return at any time to complete and submit it for review.
                 </p>

                 <div class="summary-card-list">
                     <div class="summary-row-list">
                         <strong>Draft ID:</strong>
                         <span x-text="businessId"></span>
                     </div>

                     <div class="summary-row-list">
                         <strong>Status:</strong>
                         <span style="color:#f39c12;">Draft</span>
                     </div>
                 </div>

                 <p style="color:#666;">
                     To publish your listing, please complete all required sections and submit it for review.
                 </p>

                 <button type="button" class="btn-primary-list" @click="goToStep(2)">
                     Continue Editing
                 </button>
             </div>
         </template>
         <!-- Submitted -->
         <template x-if="formData.status == 'pending'">
             <div>

                 <h1 style="color:#2ecc71">✅ Final Confirmation</h1>

                 <div style="font-size:16px;font-weight:600;margin-bottom:15px;">
                     Thank you <span x-text="userName"></span>.
                 </div>

                 <p class="intro-text-list" style="background:#f4f9f4;border-left-color:#2ecc71;color:#444;">
                     Your business for sale listing has been created and is now being reviewed by our customer services
                     team.
                     Please allow at least one working day for it to be processed and go live on the site.
                 </p>

                 <div class="summary-card-list">
                     <div class="summary-row-list">
                         <strong>Your Listing ID is:</strong>
                         <span x-text="businessId"></span>
                         <span style="color:#777;">
                             (Please refer to this number when making inquiries.)
                         </span>
                     </div>

                     <div class="summary-row-list">
                         <strong>Your subscription package is:</strong>
                         <span x-text="packageDisplay"></span>
                     </div>

                     <div class="summary-row-list">
                         <strong>Your user name is:</strong>
                         <span x-text="userEmail"></span>
                     </div>
                 </div>

                 <p style="font-size:14px;color:#555;">
                     We wish you the best of luck in finding a buyer and we will do all we can to help you sell your
                     business
                     quickly and easily.
                 </p>

                 <p style="font-size:14px;color:#555;">
                     If you have any questions please
                     <a href="{{ route('contact') }}" class="action-link-list">
                         contact us >>
                     </a>
                 </p>

                 <button type="button" class="btn-primary-list" style="background:#008080" @click="printPage()">
                     🖨️ Print This Page
                 </button>

             </div>
         </template>
         <template x-if="formData.status === 'published'">
             <div>

                 <h2 style="color:#2ecc71;">🎉 Listing Published</h2>

                 <p class="intro-text-list" style="background:#f4f9f4;border-left-color:#2ecc71;">
                     Congratulations! Your business listing is now live and visible to potential buyers.
                 </p>

                 <div class="summary-card-list">
                     <div class="summary-row-list">
                         <strong>Listing ID:</strong>
                         <span x-text="businessId"></span>
                     </div>

                     <div class="summary-row-list">
                         <strong>Status:</strong>
                         <span style="color:#2ecc71;">Published</span>
                     </div>
                 </div>

             </div>
         </template>
     </div>

     <div x-show="loading" class="alert alert-info">
         <span>Processing your listing...</span>
     </div>
 </div>
