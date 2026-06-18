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

    <div class="container-list" x-data="advertForm('{{ $uuid ?? request()->uuid }}')" x-init="init()" @keydown.enter="submitCurrentStep()">

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
        <div x-show="success" x-transition class="draft-success-message">
            <div class="icon">✓</div>
            <div>
                <p x-text="success"></p>
            </div>
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

        @include('components.step1')

        @include('components.step2')
        @include('components.step3')
        @include('components.step4')

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

        <div x-cloak x-show="showPreviewModal" x-transition class="preview-overlay" @click.self="showPreviewModal = false">

            <div class="preview-modal">

                <div class="preview-header">
                    <h4 style="margin:0;">Business Listing Preview</h4>

                    <button type="button" class="close-btn" @click="showPreviewModal = false">
                        ×
                    </button>
                </div>

                <div class="preview-body">

                    <table class="preview-table">
                        <tbody>
                            <template x-for="[key,value] in Object.entries(formData)" :key="key">
                                <tr>
                                    <th x-text="key.replace(/_/g,' ')"></th>

                                    <td
                                        x-text="
                                Array.isArray(value)
                                ? value.join(', ')
                                : (value === true ? 'Yes'
                                : value === false ? 'No'
                                : value || '-')
                            ">
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                </div>

                <div class="preview-footer">
                    <button type="button" class="btn-print" @click="window.print()">
                        Print Preview
                    </button>
                </div>

            </div>

        </div>
    </div>
    <script defer src="//unpkg.com/alpinejs"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function advertForm(uuid = null) {
            return {
                uuid: uuid,
                businessId: null,
                currentStep: 2,
                totalSteps: 5,
                videoPreviewUrl: '',
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
                savingDraft: false,
                draftMessage: '',

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

                async init() {
                    if (this.uuid) {
                        await this.loadBusiness();
                    }
                },


                previewVideo() {
                    const url = this.formData.embed_video;

                    const match = url.match(
                        /(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/i
                    );

                    if (match) {
                        this.videoPreviewUrl =
                            `https://www.youtube.com/embed/${match[1]}`;
                    } else {
                        alert('Please enter a valid YouTube URL');
                    }
                },

                async loadBusiness() {
                    try {
                        this.loading = true;

                        const response = await fetch(`/seller/business/${this.uuid}`);

                        const result = await response.json();
                        if (!result.success) {
                            throw new Error('Business not found');
                        }

                        const business = result.data;

                        this.businessId = business.id;

                        this.formData = {
                            ...this.formData,
                            ...business
                        };

                    } catch (error) {
                        console.error(error);
                        this.error = error.message;
                    } finally {
                        this.loading = false;
                    }
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
                        const response = await fetch('{{ route('seller.business.create') }}', {
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
                        console.log(this.formData);
                        const endpoint = `/seller/business/${this.businessId}/step`;
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
                    this.savingDraft = true;
                    await this.submitCurrentStep();
                    if (!this.error) {
                        this.success =
                            'Draft saved successfully! Your progress has been stored and you can continue editing anytime.';
                        setTimeout(() => {
                            this.success = null;
                        }, 10000);
                        this.savingDraft = false;
                    }
                },

                previewListing() {
                    this.showPreviewModal = true;
                },

                printPage() {
                    window.print();
                },

                async uploadFiles(event, type) {
                    const files = Array.from(event.target.files);

                    const uploadData = new FormData();

                    files.forEach(file => {
                        uploadData.append('files[]', file);
                    });

                    uploadData.append('type', type);

                    const response = await fetch('/seller/upload-files', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        },
                        body: uploadData
                    });

                    const result = await response.json();

                    console.log('Upload response:', result);

                    if (result.success) {
                        if (type === 'photo') {
                            this.formData.photographs = [
                                ...(this.formData.photographs || []),
                                ...(result.paths || [])
                            ];
                        } else {
                            this.formData.documents = [
                                ...(this.formData.documents || []),
                                ...(result.paths || [])
                            ];
                        }
                    }
                },
                async removeFile(index, path, type) {

                    await fetch('/seller/delete-file', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        },
                        body: JSON.stringify({
                            path
                        })
                    });

                    if (type === 'photo') {
                        this.formData.photographs.splice(index, 1);
                    } else {
                        this.formData.documents.splice(index, 1);
                    }
                },
                goToStep(step) {
                    this.currentStep = step;

                    // Optional: scroll to top
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
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
