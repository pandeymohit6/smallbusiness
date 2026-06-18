<!-- Step 3: Review Your Order -->
        <div id="tab-page-3" class="wizard-tab-list" :class="{ 'active-tab-list': currentStep === 4 }">
            <h1>Review Your Order</h1>
            <div class="intro-text-list">Fields marked * are mandatory.</div>

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

            <div class="action-buttons-list bottom-list btn-left-group-list">
                <button type="button" class="btn-secondary-list btn-back-list" @click="prevStep()">
                    < Back</button>

                        <button type="button" class="btn-primary-list" @click="nextStep()">Submit Order >></button>
            </div>

        </div>