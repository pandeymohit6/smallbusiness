@extends('frontend.layouts.sellerform')

@section('content')
    <div class="header-wrapper_1">
        <div class="top-bar">
            <div class="container top_mob">
                <a href="{{ route('home') }}" class="logo-desktop">
                    SmallBusinessesForSale.com<span class="stars">★</span>
                </a>
            </div>
        </div>
    </div>

    <div class="container-list" x-data="advertForm()" x-init="init()" @keydown.enter="submitCurrentStep()">

        <div class="top-nav-list">
            Status: Logged in as <strong id="user-display-name">{{ auth()->user()->email ?? 'User' }}</strong> |
            <a href="{{ route('home') }}">Home</a> |
            <a href="{{ route('seller.dashboard') }}">My account</a> |
            <a href="{{ route('logout') }}">Logout</a>
        </div>

        <div class="progress-container-list">
            <div class="progress-line-active-list" :style="`width:${progressPercentage}%`">
            </div>
            <template x-for="(step, index) in steps" :key="index">
                <div class="step-list"
                    :class="{
                        'completed-list': currentStep > index + 1,
                        'active-list': currentStep === index + 1,
                        'opacity-50 cursor-not-allowed': index === 0
                    }"
                    @click="if(index !== 0) currentStep = index + 1">
                    <span x-text="index + 1"></span>
                    <span class="step-label-list" x-text="step"></span>
                </div>
            </template>
        </div>

        <!-- Alert Messages -->
        <div x-show="loading" style="margin: 15px 0;" class="alert alert-info">
            <span>💾 Saving your progress...</span>
        </div>
        <div x-show="error" style="margin: 15px 0;" class="alert alert-danger">
            <strong>Error:</strong> <span x-text="error"></span>
        </div>
        <div x-show="success" style="margin: 15px 0;" class="alert alert-success">
            <span x-text="success"></span>
        </div>
        <div x-show="validationSummary.length > 0" class="validation-summary" x-transition>

            <div class="validation-summary-header">
                ⚠ We need you to correct or provide more information.
            </div>

            <div class="validation-summary-subtitle">
                Please see each marked section.
            </div>

            <ul class="validation-summary-list">
                <template x-for="(item,index) in validationSummary" :key="index">
                    <li x-text="item"></li>
                </template>
            </ul>

        </div>

        <!-- Step 1: Build Your Listing -->
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
                    <button type="button" class="btn-secondary-list" @click="saveDraft()">💾 Save For Later</button>
                </div>
                <button type="button" class="btn-primary-list" @click="nextStep()"
                    :disabled="currentStep > 2 && !stepSaved"
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
                            <input type="radio" name="prop_status" value="Free Property"
                                x-model="formData.property_status" @change="delete validationErrors.property_status">
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
                                <select id="asking_price_range" x-model="formData.asking_price_range"
                                    @change="autoSave()"
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
                        <input type="file" @change="handlePhotoUpload" multiple><br>
                        <button type="button" class="btn-upload-list">Upload Photo</button>
                    </div>
                </div>
                <div class="form-group-list">
                    <label>Documents (Upload a Document)</label>
                    <div class="upload-box-list">
                        <input type="file" @change="handleDocumentUpload"><br>
                        <button type="button" class="btn-upload-list">Upload Document</button>
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
                        <button type="button" class="btn-secondary-list" style="padding: 6px 12px; font-size:12px;">TEST
                            VIDEO</button>
                    </div>
                </div>
            </div>

            <div class="action-buttons-list bottom">
                <div>
                    <button type="button" class="btn-secondary-list" @click="previewListing()">👁️ Preview
                        Listing</button>
                    <button type="button" class="btn-secondary-list" @click="saveDraft()">💾 Save For Later</button>
                </div>
                <button type="submit" class="btn-primary-list" @click="nextStep()"
                    :disabled="currentStep > 2 && !stepSaved"
                    :style="(currentStep > 2 && !stepSaved) ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                    <span x-show="currentStep === 2 || stepSaved">Continue Building Listing >></span>
                    <span x-show="currentStep > 2 && !stepSaved">⏳ Saving... Please wait</span>
                </button>
            </div>
        </div>

        <!-- Step 2: Further Business Details -->
        <div id="tab-page-2" class="wizard-tab-list" :class="{ 'active-tab-list': currentStep === 3 }">
            <h1>Further Business Details</h1>
            <div class="intro-text-list">
                Please provide further information on your business for sale. You may enter as much or as little information
                as you wish.
            </div>

            <div class="action-buttons-list">
                <div class="btn-left-group-list">
                    <button type="button" class="btn-secondary-list btn-back-list" @click="prevStep()">
                        < Back</button>
                            <button type="button" class="btn-secondary-list" @click="previewListing()">👁️ Preview
                                Listing</button>
                </div>
                <button type="button" class="btn-primary-list" @click="nextStep()"
                    :disabled="currentStep > 3 && !stepSaved"
                    :style="(currentStep > 3 && !stepSaved) ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                    <span x-show="currentStep === 3 || stepSaved">Continue Building Listing >></span>
                    <span x-show="currentStep > 3 && !stepSaved">⏳ Saving... Please wait</span>
                </button>
            </div>

            <div class="form-section-list">
                <h2>Section A - Environment</h2>
                <div class="form-group-list">
                    <label>Location</label>
                    <textarea x-model="formData.location_details" placeholder="Describe the location of the business..."
                        @blur="autoSave()"></textarea>
                </div>
                <div class="form-group-list">
                    <label>Premises Details</label>
                    <textarea x-model="formData.premises_details" placeholder="Describe the premises structural blocks..."
                        @blur="autoSave()"></textarea>
                </div>
                <div class="form-group-list">
                    <label>Competition</label>
                    <textarea x-model="formData.competition" placeholder="Describe any competitive considerations..." @blur="autoSave()"></textarea>
                </div>
                <div class="form-group-list">
                    <label>Expansion Potential</label>
                    <textarea x-model="formData.expansion_potential" placeholder="Describe any opportunities for expansion..."
                        @blur="autoSave()"></textarea>
                </div>
                <div class="form-group-list">
                    <div class="checkbox-group-list">
                        <label class="checkbox-item-list"><input type="checkbox"
                                x-model="formData.accommodation_included" @change="autoSave()"> <strong>Check this box if
                                accommodation is included.</strong></label>
                    </div>
                </div>
                <div class="form-group-list" x-show="formData.accommodation_included">
                    <label>Living Accommodation Description</label>
                    <textarea x-model="formData.accommodation_description" placeholder="Describe living accommodation..."
                        @blur="autoSave()"></textarea>
                </div>
                <div class="form-group-list">
                    <label>Size in Square Feet of Property (if applicable)</label>
                    <input type="number" x-model="formData.property_size_sqft" @blur="autoSave()">
                </div>
                <div class="form-group-list">
                    <label>Planning Consent</label>
                    <textarea x-model="formData.planning_consent" placeholder="Give details of any planning permissions gained..."
                        @blur="autoSave()"></textarea>
                </div>
            </div>

            <div class="form-section-list">
                <h2>Section B - Operation</h2>
                <div class="form-group-list">
                    <label>Years Established</label>
                    <input type="number" x-model="formData.years_established" style="max-width:250px;"
                        @blur="autoSave()">
                </div>
                <div class="form-group-list">
                    <label>Type of Management</label>
                    <div class="radio-group-list">
                        <label class="radio-item-list"><input type="radio" name="management" value="Owner Managed"
                                x-model="formData.management_type"> Owner Managed</label>
                        <label class="radio-item-list"><input type="radio" name="management"
                                value="Employee Managed (Staff)" x-model="formData.management_type"> Employee Managed
                            (Staff)</label>
                        <label class="radio-item-list"><input type="radio" name="management" value="Partially Managed"
                                x-model="formData.management_type"> Partially Managed</label>
                        <label class="radio-item-list"><input type="radio" name="management" value="N/A"
                                x-model="formData.management_type"> N/A</label>
                    </div>
                </div>
                <div class="form-group-list">
                    <label>Employees</label>
                    <textarea x-model="formData.employees_details" placeholder="List details or number of staff members..."
                        @blur="autoSave()"></textarea>
                </div>
                <div class="form-group-list">
                    <label>Trading Hours</label>
                    <textarea x-model="formData.trading_hours" placeholder="List regular trading hours..." @blur="autoSave()"></textarea>
                </div>
                <div class="form-group-list">
                    <label>Support & Training</label>
                    <textarea x-model="formData.support_training" placeholder="Describe support or training options offered..."
                        @blur="autoSave()"></textarea>
                </div>
                <div class="form-group-list">
                    <div class="checkbox-group-list">
                        <label class="checkbox-item-list"><input type="checkbox" x-model="formData.e2_visa_eligible"
                                @change="autoSave()"> <strong>Check this box if the business qualifies for an E-2 Investor
                                Visa.</strong></label>
                    </div>
                </div>
            </div>

            <div class="form-section-list">
                <h2>Section C - Terms</h2>
                <div class="form-group-list">
                    <label>Relocatable</label>
                    <div class="radio-group-list">
                        <label class="radio-item-list"><input type="radio" name="relocatable" value="1"
                                x-model="formData.relocatable"> Yes</label>
                        <label class="radio-item-list"><input type="radio" name="relocatable" value="0"
                                x-model="formData.relocatable"> No</label>
                    </div>
                </div>
                <div class="form-group-list">
                    <div class="checkbox-stack-list">
                        <label class="checkbox-item-list"><input type="checkbox" x-model="formData.can_run_from_home"
                                @change="autoSave()"> <strong>Check this box if the business can be run from
                                home.</strong></label>
                        <label class="checkbox-item-list"><input type="checkbox" x-model="formData.is_franchise"
                                @change="autoSave()"> <strong>Check this box if the business is a franchise
                                opportunity.</strong></label>
                    </div>
                </div>
                <div class="form-group-list" x-show="formData.is_franchise">
                    <label>Franchise Terms</label>
                    <textarea x-model="formData.franchise_terms" @blur="autoSave()"></textarea>
                </div>
                <div class="form-group-list">
                    <div class="checkbox-stack-list">
                        <label class="checkbox-item-list"><input type="checkbox" x-model="formData.not_operating"
                                @change="autoSave()"> <strong>Check this box if the business is not operating and assets
                                are being sold.</strong></label>
                        <label class="checkbox-item-list"><input type="checkbox"
                                x-model="formData.turnaround_opportunity" @change="autoSave()"> <strong>Please tick this
                                box if the business is a turnaround opportunity or bankruptcy.</strong></label>
                        <label class="checkbox-item-list"><input type="checkbox" x-model="formData.willing_to_finance"
                                @change="autoSave()"> <strong>Please tick this box if you are willing to help finance the
                                business sale.</strong></label>
                    </div>
                </div>
                <div class="form-group-list">
                    <label>Financing Available</label>
                    <textarea x-model="formData.financing_available" @blur="autoSave()"></textarea>
                </div>
                <div class="form-group-list">
                    <label>Reason For Selling</label>
                    <textarea x-model="formData.reason_for_selling" placeholder="e.g. Retirement, ill health, structural changes, etc."
                        @blur="autoSave()"></textarea>
                </div>
            </div>

            <div class="form-section-list">
                <h2>Section D - Assets</h2>
                <div class="form-group-list">
                    <div class="checkbox-group-list" style="margin-bottom:10px;">
                        <label class="checkbox-item-list"><input type="checkbox" x-model="formData.furniture_included"
                                @change="autoSave()"> <strong>Furniture, fixtures and fittings are included in asking
                                price.</strong></label>
                    </div>
                    <label>Value of Furniture, Fixtures & Fittings</label>
                    <div class="input-group-list" style="max-width:350px;">
                        <span class="input-group-addon-list">$</span>
                        <input type="text" x-model="formData.furniture_value" @blur="autoSave()">
                        <span class="input-group-addon-right-list">[USD]</span>
                    </div>
                </div>
                <div class="form-group-list" style="margin-top:25px;">
                    <div class="checkbox-group-list" style="margin-bottom:10px;">
                        <label class="checkbox-item-list"><input type="checkbox" x-model="formData.inventory_included"
                                @change="autoSave()"> <strong>Inventory / stock is included in the asking
                                price.</strong></label>
                    </div>
                    <label>Value of Inventory / Stock</label>
                    <div class="input-group-list" style="max-width:350px;">
                        <span class="input-group-addon-list">$</span>
                        <input type="text" x-model="formData.inventory_value" @blur="autoSave()">
                        <span class="input-group-addon-right-list">[USD]</span>
                    </div>
                </div>
            </div>

            <div class="action-buttons-list bottom-list">
                <button type="button" class="btn-secondary-list btn-back-list" @click="prevStep()">
                    < Back</button>
                        <button type="button" class="btn-primary-list" @click="nextStep()"
                            :disabled="currentStep > 2 && !stepSaved"
                            :style="(currentStep > 2 && !stepSaved) ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                            <span x-show="currentStep === 2 || stepSaved">Continue Building Listing >></span>
                            <span x-show="currentStep > 2 && !stepSaved">⏳ Saving... Please wait</span>
                        </button>
            </div>
        </div>

        <!-- Step 3: Review Your Order -->
        <div id="tab-page-3" class="wizard-tab-list" :class="{ 'active-tab-list': currentStep === 4 }">
            <h1>Review Your Order</h1>
            <div class="intro-text-list">Fields marked * are mandatory.</div>

            <div class="action-buttons-list">
                <button type="button" class="btn-secondary-list btn-back-list" @click="prevStep()">
                    < Back</button>
                        <button type="button" class="btn-primary-list" @click="nextStep()"
                            :disabled="currentStep > 4 && !stepSaved"
                            :style="(currentStep > 4 && !stepSaved) ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                            <span x-show="currentStep === 4 || stepSaved">Submit Order >></span>
                            <span x-show="currentStep > 4 && !stepSaved">⏳ Saving... Please wait</span>
                        </button>
            </div>

            <div class="package-section-list">
                <h2 style="font-weight:600; margin-bottom:15px;">Your selected advertising package and the others we have
                    on offer:</h2>
                <div class="pricing-grid-list">
                    <label class="price-card-list">
                        <input type="radio" name="pkg_select" value="6-months" x-model="formData.selected_package"
                            @change="autoSave()">
                        <div class="price-info-list">
                            <span class="price-duration-list">6 Months</span>
                            <span class="price-amount-list">$399.00</span>
                        </div>
                    </label>
                    <label class="price-card-list">
                        <input type="radio" name="pkg_select" value="3-months" x-model="formData.selected_package"
                            @change="autoSave()">
                        <div class="price-info-list">
                            <span class="price-duration-list">3 Months</span>
                            <span class="price-amount-list">$299.00</span>
                        </div>
                    </label>
                    <label class="price-card-list">
                        <input type="radio" name="pkg_select" value="1-month" x-model="formData.selected_package"
                            @change="autoSave()">
                        <div class="price-info-list">
                            <span class="price-duration-list">1 Month</span>
                            <span class="price-amount-list">$199.00</span>
                        </div>
                    </label>
                </div>

                <label class="decline-option-list">
                    <input type="radio" name="pkg_select" value="test-market" x-model="formData.selected_package"
                        @change="autoSave()">
                    <span>No thanks I want to Test the Market first</span>
                </label>
            </div>

            <div class="action-buttons-list bottom-list">
                <button type="button" class="btn-secondary-list btn-back-list" @click="prevStep()">
                    < Back</button>
                        <button type="button" class="btn-primary-list" @click="nextStep()">Submit Order >></button>
            </div>
        </div>

        <!-- Step 4: Final Confirmation -->
        <div id="tab-page-4" class="wizard-tab-list" :class="{ 'active-tab-list': currentStep === 5 }">
            <h1 style="color:#2ecc71">Final Confirmation</h1>

            <div class="confirmation-box-list" x-show="!loading">
                <div style="font-size:16px; font-weight:600; margin-bottom:15px;">Thank you <span
                        x-text="userName"></span>.</div>
                <p class="intro-text-list" style="background:#f4f9f4; border-left-color:#2ecc71; color:#444;">
                    Your business for sale listing has been created and is now being reviewed by our customer services team.
                    Please allow at least one working day for it to be processed and go live on the site.
                </p>

                <div class="summary-card-list">
                    <div class="summary-row-list"><strong>Your Listing ID is:</strong> <span x-text="businessId"></span>
                        <span style="color:#777;">(Please refer to this number when making inquiries.)</span>
                    </div>
                    <div class="summary-row-list"><strong>Your subscription package is:</strong> <span
                            x-text="packageDisplay"></span></div>
                    <div class="summary-row-list"><strong>Your user name is :</strong> <span x-text="userEmail"></span>
                    </div>
                </div>

                <p style="font-size:14px; margin-bottom:15px; color:#555;">We wish you the best of luck in finding a buyer
                    and we will do all we can to help you sell your business quickly and easily.</p>
                <p style="font-size:14px; margin-bottom:20px; color:#555;">If you have any questions please <a
                        href="#" class="action-link-list">contact us >></a></p>

                <button type="button" class="btn-primary-list" style="background:#008080" @click="printPage()">🖨️
                    Print This Page</button>
            </div>

            <div x-show="loading" class="alert alert-info">
                <span>Processing your listing...</span>
            </div>
        </div>

        <div class="footer-note-list" id="disclaimer-note" x-show="currentStep !== totalSteps">
            Please note: your video, documents and website address will not show on your listing until you buy an
            advertising package.
            In addition this will only show on your listing for registered buyers. Buyers will use this as a way to contact
            you rather
            than going through BusinessesForSale.com, so by adding details we hope that the buyers that do contact you will
            be serious
            about buying your business. Any photographs which reveal the name and location of your business will not be
            displayed until
            you buy an advertising package.
        </div>

        <div class="footer-links-list">
            <a href="#">Terms and Conditions</a> | <a href="#">Privacy Policy</a> | <a href="#">Cookie
                Policy</a> | <a href="#">Contact Us</a>
            <p style="margin-top:10px; color:#aaa;">© 1996 - 2026 Dynamis Ltd and all subsidiaries.</p>
        </div>
      <style>
    [x-cloak] {
        display: none !important;
    }

    .preview-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .6);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .preview-modal {
        background: #fff;
        width: 100%;
        max-width: 700px;
        max-height: 80vh;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
    }

    .preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 20px;
        background: #008080;
        color: #fff;
    }

    .preview-body {
        max-height: 65vh;
        overflow-y: auto;
        padding: 15px;
    }

    .preview-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .preview-table th {
        width: 35%;
        background: #f8f9fa;
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
        text-transform: capitalize;
    }

    .preview-table td {
        padding: 8px;
        border: 1px solid #ddd;
        word-break: break-word;
    }

    .close-btn {
        border: none;
        background: #fff;
        color: #008080;
        font-size: 18px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        font-weight: bold;
    }

    .preview-footer {
        padding: 12px 20px;
        border-top: 1px solid #eee;
        text-align: right;
    }

    .btn-print {
        background: #008080;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<div x-cloak
     x-show="showPreviewModal"
     x-transition
     class="preview-overlay"
     @click.self="showPreviewModal = false">

    <div class="preview-modal">

        <div class="preview-header">
            <h4 style="margin:0;">Business Listing Preview</h4>

            <button type="button"
                    class="close-btn"
                    @click="showPreviewModal = false">
                ×
            </button>
        </div>

        <div class="preview-body">

            <table class="preview-table">
                <tbody>
                    <template x-for="[key,value] in Object.entries(formData)" :key="key">
                        <tr>
                            <th x-text="key.replace(/_/g,' ')"></th>

                            <td x-text="
                                Array.isArray(value)
                                ? value.join(', ')
                                : (value === true ? 'Yes'
                                : value === false ? 'No'
                                : value || '-')
                            "></td>
                        </tr>
                    </template>
                </tbody>
            </table>

        </div>

        <div class="preview-footer">
            <button type="button"
                    class="btn-print"
                    @click="window.print()">
                Print Preview
            </button>
        </div>

    </div>

</div>
    </div>
    <script defer src="//unpkg.com/alpinejs"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function advertForm() {
            return {
                currentStep: 2,
                totalSteps: 5,
                steps: ['Contact Details', 'Build Your Listing', 'Further Details', 'Review Your Order',
                    'Final Confirmation'
                ],
                loading: false,
                showPreviewModal: false,
                error: null,
                success: null,
                businessId: null,
                stepSaved: false,
                userName: '{{ auth()->user()->name ?? 'User' }}',
                userEmail: '{{ auth()->user()->email ?? '' }}',
                autoSaveTimeout: null,
                validationErrors: {},
                validationSummary: [],

                validationRules: {
                    1: {
                        listing_headline: 'required|max:255',
                        general_summary: 'required|min:10',
                        business_status: 'required',
                        category: 'required',
                        region: 'required'
                    },
                    2: {
                        asking_price_range: 'required',
                        revenue_range: 'required'
                    }
                },

                formData: {
                    listing_headline: '',
                    general_summary: '',
                    business_status: 'For Sale',
                    category: '',
                    region: '',
                    city: '',
                    property_status: '',
                    asking_price_range: '',
                    specific_asking_price: '',
                    asking_price_on_request: false,
                    quick_sale_negotiable: false,
                    revenue_range: '',
                    specific_revenue: '',
                    revenue_on_request: false,
                    cash_flow_range: '',
                    specific_cash_flow: '',
                    cash_flow_on_request: false,
                    photographs: [],
                    documents: [],
                    website_address: '',
                    embed_video: '',
                    location_details: '',
                    premises_details: '',
                    competition: '',
                    expansion_potential: '',
                    accommodation_included: false,
                    accommodation_description: '',
                    property_size_sqft: '',
                    planning_consent: '',
                    years_established: '',
                    management_type: '',
                    employees_details: '',
                    trading_hours: '',
                    support_training: '',
                    e2_visa_eligible: false,
                    relocatable: null,
                    can_run_from_home: false,
                    is_franchise: false,
                    franchise_terms: '',
                    not_operating: false,
                    turnaround_opportunity: false,
                    willing_to_finance: false,
                    financing_available: '',
                    reason_for_selling: '',
                    furniture_included: false,
                    furniture_value: '',
                    inventory_included: false,
                    inventory_value: '',
                    selected_package: 'test-market'
                },

                init() {
                    // Initialize form
                },

                get progressPercentage() {
                    return ((this.currentStep - 1) / (this.totalSteps - 1)) * 100;
                },

                navigateToTab(step) {
                    if (step < 1 || step > this.totalSteps) return;

                    this.currentStep = step;

                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },

                async nextStep() {
                    if (this.currentStep < 5) {
                        this.stepSaved = false;
                        await this.submitCurrentStep();

                        if (this.error || !this.stepSaved) {
                            this.error = this.error || 'Please save this step before moving forward';
                            return;
                        }

                        this.currentStep++;
                    } else {
                        await this.finalize();
                    }
                },

                prevStep() {
                    if (this.currentStep > 2) {
                        this.currentStep--;
                    }
                },

                autoSave() {
                    this.loading = true; // Add this
                    clearTimeout(this.autoSaveTimeout);
                    this.autoSaveTimeout = setTimeout(() => {
                        this.submitCurrentStep();
                    }, 5000);
                },
                async submitCurrentStep() {
                    // Validate first
                    if (!this.validateStep(this.currentStep)) {
                        this.error = 'Please fill in all required fields correctly';
                        return;
                    }

                    this.loading = true;
                    this.error = null;

                    if (!this.businessId) {
                        await this.createBusiness();
                    } else {
                        await this.saveStep();
                    }
                },

                async createBusiness() {
                    this.loading = true;
                    this.error = null;

                    try {
                        const response = await fetch('{{ route('api.seller.business.create') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    ?.content ||
                                    '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                listing_headline: this.formData.listing_headline,
                                general_summary: this.formData.general_summary,
                                business_status: this.formData.business_status,
                                category: this.formData.category,
                                region: this.formData.region,
                                country_code: '{{ $country_code ?? 'usa' }}'
                            })
                        });

                        const data = await response.json();
                        console.log('Create Business Response:', response.status, data);
                        if (!response.ok) {
                            this.validationErrors = data.errors || {};
                            throw new Error(data.message || data.error ||
                                `Failed to create business (${response.status})`);
                        }

                        this.businessId = data.business_id;
                        this.stepSaved = true;
                        this.success = 'Business listing started!';
                        console.log('Business ID:', this.businessId);
                        setTimeout(() => this.success = null, 3000);
                    } catch (error) {
                        console.error('Create Business Error:', error);
                        this.stepSaved = false;
                        this.error = error.message || 'An unexpected error occurred';
                    } finally {
                        this.loading = false;
                    }
                },

                async saveStep() {
                    this.loading = true;
                    this.error = null;

                    try {
                        const endpoint = `/api/seller/business/${this.businessId}/step`;
                        console.log('Saving step:', this.currentStep, 'to', endpoint);

                        const response = await fetch(endpoint, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    ?.content ||
                                    '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                step: this.currentStep,
                                data: this.formData
                            })
                        });

                        const data = await response.json();
                        console.log('Save Step Response:', response.status, data);
                        if (!response.ok) throw new Error(data.message || data.error ||
                            `Failed to save step (${response.status})`);

                        this.stepSaved = true;
                        console.log('Step saved successfully');
                    } catch (error) {
                        console.error('Save Step Error:', error);
                        this.stepSaved = false;
                        this.error = error.message || 'An unexpected error occurred';
                    } finally {
                        this.loading = false;
                    }
                },

                async finalize() {
                    this.loading = true;
                    this.error = null;

                    try {
                        const endpoint = `/api/seller/business/${this.businessId}/finalize`;
                        console.log('Finalizing business at:', endpoint);

                        const response = await fetch(endpoint, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    ?.content ||
                                    '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                selected_package: this.formData.selected_package
                            })
                        });

                        const data = await response.json();
                        console.log('Finalize Response:', response.status, data);
                        if (!response.ok) throw new Error(data.message || data.error ||
                            `Failed to finalize (${response.status})`);

                        console.log('Business finalized successfully');
                        this.currentStep = 5;
                    } catch (error) {
                        console.error('Finalize Error:', error);
                        this.error = error.message || 'An unexpected error occurred';
                    } finally {
                        this.loading = false;
                    }
                },

                async saveDraft() {
                    await this.submitCurrentStep();
                    if (!this.error) {
                        this.success = 'Draft saved! You can continue later.';
                        setTimeout(() => this.success = null, 3000);
                    }
                },

                previewListing() {
                    this.showPreviewModal = true;
                },

                printPage() {
                    window.print();
                },

                handlePhotoUpload(event) {
                    const files = event.target.files;
                    this.formData.photographs = Array.from(files).map(f => f.name);
                },

                handleDocumentUpload(event) {
                    const files = event.target.files;
                    this.formData.documents = Array.from(files).map(f => f.name);
                },

                get packageDisplay() {
                    const packages = {
                        '6-months': '6 Months ($399.00)',
                        '3-months': '3 Months ($299.00)',
                        '1-month': '1 Month ($199.00)',
                        'test-market': 'Test the Market'
                    };
                    return packages[this.formData.selected_package] || 'Test the Market';
                },

                validateField(fieldName, value, rules) {
                    const ruleArray = rules.split('|');
                    for (const rule of ruleArray) {
                        const [ruleName, ...params] = rule.split(':');

                        if (ruleName === 'required' && !value) {
                            return `${fieldName.replace(/_/g, ' ')} is required`;
                        }
                        if (ruleName === 'max' && value && value.length > parseInt(params[0])) {
                            return `${fieldName.replace(/_/g, ' ')} cannot exceed ${params[0]} characters`;
                        }
                        if (ruleName === 'min' && value && value.length < parseInt(params[0])) {
                            return `${fieldName.replace(/_/g, ' ')} must be at least ${params[0]} characters`;
                        }
                    }
                    return null;
                },

                validateStep(step) {

                    this.validationErrors = {};
                    this.validationSummary = [];

                    let valid = true;

                    if (!this.formData.listing_headline?.trim()) {

                        this.validationErrors.listing_headline =
                            'Please enter a headline for your listing';

                        this.validationSummary.push(
                            'Please enter a headline for your listing'
                        );

                        valid = false;
                    }

                    if (!this.formData.general_summary?.trim()) {

                        this.validationErrors.general_summary =
                            'Please enter a general summary of your business';

                        this.validationSummary.push(
                            'Please enter a general summary of your business'
                        );

                        valid = false;
                    }

                    if (!this.formData.category?.trim()) {

                        this.validationErrors.category =
                            'Please choose a business type';

                        this.validationSummary.push(
                            'Please choose a business type'
                        );

                        valid = false;
                    }

                    if (!this.formData.region?.trim()) {

                        this.validationErrors.region =
                            'Please select a region';

                        this.validationSummary.push(
                            'Please select a region'
                        );

                        valid = false;
                    }

                    if (!this.formData.property_status?.trim()) {

                        this.validationErrors.property_status =
                            'Please select a property status';

                        this.validationSummary.push(
                            'Please select a property status'
                        );

                        valid = false;
                    }

                    // Asking Price (Range OR Specific Value)
                    const askingPriceValid =
                        this.formData.asking_price_range ||
                        (this.formData.specific_asking_price &&
                            this.formData.specific_asking_price.trim());


                    if (!askingPriceValid) {

                        this.validationErrors.asking_price_range = true;
                        this.validationErrors.specific_asking_price = true;
                        this.validationSummary.push(
                            'Please select an asking price band or enter a specific numeric value for asking price'
                        );

                        valid = false;
                    }

                    // Revenue (Range OR Specific Value)
                    const revenueValid =
                        this.formData.revenue_range ||
                        (this.formData.specific_revenue &&
                            this.formData.specific_revenue.trim());

                    if (!revenueValid) {

                        this.validationErrors.revenue_range = true;

                        this.validationSummary.push(
                            'Please select a sales revenue band or enter a specific numeric value for sales revenue'
                        );

                        valid = false;
                    }

                    // Cash Flow (Range OR Specific Value)
                    const cashFlowValid =
                        this.formData.cash_flow_range ||
                        (this.formData.specific_cash_flow &&
                            this.formData.specific_cash_flow.trim());

                    if (!cashFlowValid) {

                        this.validationErrors.cash_flow_range = true;

                        this.validationSummary.push(
                            'Please select a cash flow band or enter a specific numeric value for cash flow'
                        );

                        valid = false;
                    }

                    if (!valid) {

                        this.$nextTick(() => {

                            const summary =
                                document.querySelector('.validation-summary');

                            if (summary) {

                                summary.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }
                        });
                    }

                    return valid;
                },

                getFieldError(fieldName) {
                    return this.validationErrors[fieldName] || '';
                }
            }
        }
    </script>
@endsection
