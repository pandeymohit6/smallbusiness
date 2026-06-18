   <!-- Step 2: Build Your Listing -->
   <div id="tab-page-1" class="wizard-tab-list" :class="{ 'active-tab-list': currentStep === 2 }">
       <h1>Build Your Listing</h1>
       <div class="intro-text-list">
           Unless stated as required (*), all fields are optional. We understand that anonymity and privacy may
           sometimes be key considerations when selling a business - therefore business names and location details
           do not have to be disclosed.<br>
           <strong>To achieve the best results please ensure you fill out as much information as
               possible.</strong><br>
           Please note: Do not use all capital letters.
       </div>

       <div class="action-buttons-list">
           <div>
               <button type="button" class="btn-secondary-list" @click="previewListing()">👁️ Preview Listing</button>
               <button type="button" class="btn-secondary-list" @click="saveDraft()" :disabled="savingDraft">

                   <span x-show="!savingDraft">Save For Later</span>

                   <span x-show="savingDraft">
                       <i class="fa fa-spinner fa-spin"></i>
                       Saving...
                   </span>

               </button>
           </div>
           <button type="button" class="btn-primary-list" @click="nextStep()" :disabled="currentStep > 2 && !stepSaved"
               :style="(currentStep > 2 && !stepSaved) ? 'opacity: 0.6; cursor: not-allowed;' : ''">
               <span x-show="currentStep === 2 || stepSaved">Continue Building Listing >></span>
               <span x-show="currentStep > 2 && !stepSaved">⏳ Saving... Please wait</span>
           </button>
       </div>

       <div class="form-section-list">
           <h2>Listing Details</h2>
           <div class="form-group-list">
               <label>Listing Headline <span>*</span></label>
               <input type="text" x-model="formData.listing_headline"
                   placeholder="e.g. Profitable and Established Coffee Shop in Devon" @blur="autoSave()"
                   :class="{
                       'input-error': validationErrors.listing_headline
                   }"
                   @input="delete validationErrors.listing_headline">
               <div class="help-text-list">This will be the title of your listing, and is limited to 15 words. We'll
                   automatically add 'For Sale' to the end of your title.</div>
           </div>
           <div class="form-group-list">
               <label>General Summary <span>*</span></label>
               <textarea x-model="formData.general_summary" placeholder="Highlight the selling points of the business for sale..."
                   @blur="autoSave()"
                   :class="{
                       'input-error': validationErrors.general_summary
                   }"
                   @input="delete validationErrors.general_summary"></textarea>

               <div class="help-text-list">Highlight the selling points. Please do not add phone numbers or email
                   addresses.</div>
           </div>
           <div class="form-group-list">
               <label>Status of Business</label>
               <div class="radio-group-list">
                   <label class="radio-item-list">
                       <input type="radio" name="status_p1" value="For Sale" x-model="formData.business_status"
                           @change="autoSave()"> For
                       Sale
                   </label>
                   <label class="radio-item-list">
                       <input type="radio" name="status_p1" value="Under Offer" x-model="formData.business_status"
                           @change="autoSave()">
                       Under Offer
                   </label>
                   <label class="radio-item-list">
                       <input type="radio" name="status_p1" value="Sold Subject to Contract"
                           x-model="formData.business_status" @change="autoSave()"> Sold Subject to Contract
                   </label>
               </div>

           </div>
       </div>

       <div class="form-section-list">
           <h2>Select Your Business Type *</h2>
           <div class="form-group-list">
               <label>Categories <span>*</span></label>
               <input type="text" x-model="formData.category" placeholder="Search categories..." @blur="autoSave()"
                   :class="{
                       'input-error': validationErrors.category
                   }"
                   @input="delete validationErrors.category">
           </div>
       </div>

       <div class="form-section-list">
           <h2>Select Region then City / Town</h2>
           <div class="form-group-list">
               <label>Region <span>*</span></label>
               <select id="region" x-model="formData.region" required @change="autoSave()"
                   :class="{
                       'select-error': validationErrors.asking_price_range
                   }"
                   @input="delete validationErrors.asking_price_range">
                   <option value="">Select...</option>
                   <option value="undisclosed">Undisclosed</option>
                   <option value="alabama">Alabama</option>
                   <option value="alaska">Alaska</option>
                   <option value="arizona">Arizona</option>
                   <option value="arkansas">Arkansas</option>
                   <optgroup label="California">
                       <option value="california-north">&nbsp;&nbsp;&nbsp;California - North</option>
                       <option value="california-south">&nbsp;&nbsp;&nbsp;California - South</option>
                   </optgroup>
                   <option value="colorado">Colorado</option>
                   <option value="connecticut">Connecticut</option>
                   <option value="delaware">Delaware</option>
                   <option value="dc">District of Columbia</option>
                   <option value="florida">Florida</option>
                   <option value="georgia">Georgia</option>
                   <option value="hawaii">Hawaii</option>
               </select>

           </div>
           <div class="form-group-list">
               <label>City / Town</label>
               <input type="text" x-model="formData.city" placeholder="Start typing name of town or city..."
                   @blur="autoSave()">
           </div>
       </div>

       <div class="form-section-list">
           <h2>Property and Financial Details</h2>
           <div class="form-group-list">
               <label>Property Status <span>*</span></label>
               <div class="radio-group-list"
                   :class="{
                       'radio-group-error': validationErrors.property_status
                   }">

                   <label class="radio-item-list">
                       <input type="radio" name="prop_status" value="Free Property" x-model="formData.property_status"
                           @change="delete validationErrors.property_status">
                       Free Property
                   </label>

                   <label class="radio-item-list">
                       <input type="radio" name="prop_status" value="Lease" x-model="formData.property_status"
                           @change="delete validationErrors.property_status">
                       Lease
                   </label>

                   <label class="radio-item-list">
                       <input type="radio" name="prop_status" value="Both For Sale and Leasehold"
                           x-model="formData.property_status" @change="delete validationErrors.property_status">
                       Both For Sale and Leasehold
                   </label>

                   <label class="radio-item-list">
                       <input type="radio" name="prop_status" value="N/A" x-model="formData.property_status"
                           @change="delete validationErrors.property_status">
                       N/A
                   </label>

               </div>
               <div class="help-text-test">Is real property included or is the property leased by the business?</div>
           </div>

           <div class="form-group-list">
               <label>Asking Price <span>*</span></label>
               <div class="financial-row-list">
                   <div class="financial-field-list">
                       <span style="font-size:12px; color:#666; display:block; margin-bottom:5px;">Select a
                           range</span>
                       <div class="input-group-list">
                           <span class="input-group-addon-list">$</span>
                           <select id="asking_price_range" x-model="formData.asking_price_range" @change="autoSave()"
                               :class="{
                                   'select-error': validationErrors.asking_price_range
                               }"
                               @input="delete validationErrors.asking_price_range">
                               <option value="">Select range...</option>
                               <option>Under $100k</option>
                               <option>$100k - $250k</option>
                               <option>$250k - $500k</option>
                               <option>$500k - $1m</option>
                               <option>$1m - $5m</option>
                               <option>Over $5m</option>
                               <option>Undisclosed</option>
                           </select>
                       </div>
                   </div>
                   <div class="financial-or-list">OR</div>
                   <div class="financial-field-list">
                       <span style="font-size:12px; color:#666; display:block; margin-bottom:5px;">Specific asking
                           price</span>
                       <div class="input-group-list">
                           <span class="input-group-addon-list">$</span>
                           <input type="text" x-model="formData.specific_asking_price" placeholder="[USD]"
                               @blur="autoSave()"
                               @change="delete validationErrors.asking_price_range;
                                             delete validationErrors.specific_asking_price;
                                                autoSave();"
                               :class="{ 'select-error': validationErrors.asking_price_range }">
                       </div>
                   </div>
               </div>

               <div class="checkbox-group-list">
                   <label class="checkbox-item-list"><input type="checkbox"
                           x-model="formData.asking_price_on_request" @change="autoSave()"> Check this box to display
                       as "On request" only.</label>
               </div>
               <div class="help-text-list">Many Buyers search our database of businesses by price range. If you choose
                   "Undisclosed", some buyers may not find your listing.</div>
               <div class="checkbox-group-list" style="margin-top: 10px;">
                   <p style="color: #000;font-weight: 500;">Quick Sale</p>
                   <label class="checkbox-item-list"><input type="checkbox" x-model="formData.quick_sale_negotiable"
                           @change="autoSave()"> Check this box if the asking price is negotiable for a quick
                       sale.</label>
               </div>
           </div>

           <div class="form-group-list" style="margin-top:25px;">
               <label>Sales Revenue <span>*</span></label>
               <div class="financial-row-list">
                   <div class="financial-field-list">
                       <span style="font-size:12px; color:#666; display:block; margin-bottom:5px;">Select a
                           range</span>
                       <div class="input-group-list">
                           <span class="input-group-addon-list">$</span>
                           <select x-model="formData.revenue_range" @change="autoSave()"
                               :class="{
                                   'select-error': validationErrors.revenue_range
                               }"
                               @input="delete validationErrors.revenue_range">
                               <option value="">Select range...</option>
                               <option>Under $100k</option>
                               <option>$100k - $250k</option>
                               <option>$250k - $500k</option>
                               <option>$500k - $1m</option>
                               <option>$1m - $5m</option>
                               <option>Over $5m</option>
                               <option>Undisclosed</option>
                           </select>
                       </div>
                   </div>
                   <div class="financial-or-list">OR</div>
                   <div class="financial-field-list">
                       <span style="font-size:12px; color:#666; display:block; margin-bottom:5px;">Specific gross
                           revenue</span>
                       <div style="display:flex;">
                           <div class="input-group-list" style="flex:2;">
                               <span class="input-group-addon-list">$</span>
                               <input type="text" x-model="formData.specific_revenue" placeholder="[USD]"
                                   @blur="autoSave()"
                                   @change="delete validationErrors.revenue_range;
                                             delete validationErrors.specific_revenue;
                                                autoSave();"
                                   :class="{ 'select-error': validationErrors.revenue_range }">
                           </div>
                           <select style="flex:1; border-left:none;">
                               <option>Annual</option>
                           </select>
                       </div>
                   </div>
               </div>

               <div class="checkbox-group-list">
                   <label class="checkbox-item-list"><input type="checkbox" x-model="formData.revenue_on_request"
                           @change="autoSave()"> Check this box to display as "On request" only.</label>
               </div>
               <div class="help-text-list">Many Buyers search our database of businesses by gross revenue. If you
                   choose "Undisclosed", some buyers may not find your listing.</div>
           </div>

           <div class="form-group-list" style="margin-top:25px;">
               <label>Cash Flow <span>*</span></label>
               <div class="financial-row-list">
                   <div class="financial-field-list">
                       <span style="font-size:12px; color:#666; display:block; margin-bottom:5px;">Select a
                           range</span>
                       <div class="input-group-list">
                           <span class="input-group-addon-list">$</span>
                           <select x-model="formData.cash_flow_range" @change="autoSave()"
                               :class="{
                                   'select-error': validationErrors.cash_flow_range
                               }"
                               @input="delete validationErrors.cash_flow_range">
                               <option value="">Select range...</option>
                               <option>Under $100k</option>
                               <option>$100k - $250k</option>
                               <option>$250k - $500k</option>
                               <option>$500k - $1m</option>
                               <option>$1m - $5m</option>
                               <option>Over $5m</option>
                               <option>Undisclosed</option>
                           </select>
                       </div>
                   </div>
                   <div class="financial-or-list">OR</div>
                   <div class="financial-field-list">
                       <span style="font-size:12px; color:#666; display:block; margin-bottom:5px;">Specific cash
                           flow</span>
                       <div class="input-group-list">
                           <span class="input-group-addon-list">$</span>
                           <input type="text" x-model="formData.specific_cash_flow" placeholder="[USD]"
                               @blur="autoSave()"
                               @change="delete validationErrors.cash_flow_range;
                                             delete validationErrors.specific_cash_flow;
                                                autoSave();"
                               :class="{ 'select-error': validationErrors.cash_flow_range }">
                       </div>
                   </div>
               </div>
               <div class="checkbox-group-list">
                   <label class="checkbox-item-list"><input type="checkbox" x-model="formData.cash_flow_on_request"
                           @change="autoSave()"> Check this box to display as "On request" only.</label>
               </div>
               <div class="help-text-list">Many Buyers search our database of businesses by cash flow. If you choose
                   "Undisclosed", some buyers may not find your listing.</div>
           </div>
       </div>

       <div class="form-section-list">
           <h2>Add Photographs and Documents</h2>
           <div class="form-group-list">
               <label>Photographs (Upload a Photo)</label>
               <div class="upload-box-list">
                   <input type="file" x-ref="photoInput" multiple accept="image/*" style="display:none"
                       @change="uploadFiles($event, 'photo')">

                   <button type="button" class="btn-upload-list" @click="$refs.photoInput.click()">
                       Upload Photo
                   </button>
               </div>
           </div>
           <div class="photo-gallery" x-show="formData.photographs.length">
               <template x-for="(photo, index) in formData.photographs" :key="index">
                   <div class="photo-item">
                       <img :src="'/storage/' + photo">

                       <div class="photo-overlay">
                           <a :href="'/storage/' + photo" target="_blank">View</a>

                           <button type="button" @click="removeFile(index, photo, 'photo')">
                               ✕
                           </button>
                       </div>
                   </div>
               </template>
           </div>
           <div class="form-group-list">
               <label>Documents (Upload a Document)</label>
               <div class="upload-box-list">

                   <input type="file" x-ref="documentInput" multiple style="display:none"
                       @change="uploadFiles($event, 'document')">

                   <button type="button" class="btn-upload-list" @click="$refs.documentInput.click()">
                       Upload Document
                   </button>
               </div>
               <div x-show="formData.documents.length" class="uploaded-files-list">
                   <template x-for="(doc, index) in formData.documents" :key="index">
                       <div class="uploaded-file-card">

                           <div class="file-info">
                               <div class="file-icon">📄</div>

                               <div class="file-details">
                                   <div class="file-name" x-text="doc.split('/').pop()"></div>
                                   <div class="file-path" x-text="doc"></div>
                               </div>
                           </div>

                           <div class="file-actions">
                               <a :href="'/storage/' + doc" target="_blank" class="btn-view-file">
                                   View
                               </a>

                               <button type="button" class="btn-delete-file"
                                   @click="removeFile(index, doc, 'document')">
                                   Remove
                               </button>
                           </div>

                       </div>
                   </template>
               </div>
           </div>
           <div class="form-group-list">
               <label>Website Address</label>
               <input type="text" x-model="formData.website_address" placeholder="http://" @blur="autoSave()">
           </div>
           <div class="form-group-list">
               <label for="video">Embed Video</label>
               <textarea id="video" x-model="formData.embed_video"
                   placeholder="Enter embed HTML code from YouTube, Google Video etc."></textarea>
               <div style="margin-top: 10px;">
                   <button type="button" @click="previewVideo()" class="btn-secondary-list"
                       style="padding: 6px 12px; font-size:12px;">TEST
                       VIDEO</button>
               </div>
               <div x-show="videoPreviewUrl" class="mt-3">
                   <iframe width="100%" height="400" :src="videoPreviewUrl" frameborder="0" allowfullscreen>
                   </iframe>
               </div>
           </div>
       </div>

       <div class="action-buttons-list bottom">
           <div>
               <button type="button" class="btn-secondary-list" @click="previewListing()">👁️ Preview
                   Listing</button>
               <button type="button" class="btn-secondary-list" @click="saveDraft()" :disabled="savingDraft">

                   <span x-show="!savingDraft">Save For Later</span>

                   <span x-show="savingDraft">
                       <i class="fa fa-spinner fa-spin"></i>
                       Saving...
                   </span>

               </button>
               <div x-show="success" x-transition class="draft-success-message">
                   <div class="icon">✓</div>
                   <div>
                       <p x-text="success"></p>
                   </div>
               </div>
           </div>
           <button type="submit" class="btn-primary-list" @click="nextStep()"
               :disabled="currentStep > 2 && !stepSaved"
               :style="(currentStep > 2 && !stepSaved) ? 'opacity: 0.6; cursor: not-allowed;' : ''">
               <span x-show="currentStep === 2 || stepSaved">Continue Building Listing >></span>
               <span x-show="currentStep > 2 && !stepSaved">⏳ Saving... Please wait</span>
           </button>
       </div>
   </div>
