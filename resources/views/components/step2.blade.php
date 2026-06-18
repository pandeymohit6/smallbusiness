<!-- Step 3: Further Business Details -->
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
                            <button type="button" class="btn-secondary-list" @click="saveDraft()"> Save For
                                Later</button>
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
                    <textarea x-model="formData.location_details" placeholder="Describe the location of the business..." @blur="autoSave()"></textarea>
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
                        <label class="checkbox-item-list"><input type="checkbox" x-model="formData.accommodation_included"
                                @change="autoSave()"> <strong>Check this box if
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
                            :disabled="currentStep > 3 && !stepSaved"
                            :style="(currentStep > 3 && !stepSaved) ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                            <span x-show="currentStep === 3 || stepSaved">Continue Building Listing >></span>
                            <span x-show="currentStep > 3 && !stepSaved">⏳ Saving... Please wait</span>
                        </button>
            </div>
        </div>