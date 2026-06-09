@extends('frontend.layouts.app')

@section('content')
    <div class="registration-container-reg-buy">
        <div class="page-header-reg-buy">
            <h1>Register as a Business Buyer</h1>
            <div class="accent-line-reg-buy"></div>
        </div>
        <div class="utility-bar-reg-buy">
            <a href="javascript:history.back()" class="btn-back-reg-buy">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back
            </a>
            <div class="required-indicator-reg-buy">* Required field</div>
        </div>

        <form x-data="buyerRegistration()" @submit.prevent="submitForm" class="form-card-reg-buy">
            <!-- Pass dynamic data as JSON to Alpine -->
            <script type="application/json" id="registration-data">
                {
                    "countries": {!! json_encode($countries ?? []) !!},
                    "buyerTypes": {!! json_encode($buyerTypes ?? []) !!},
                    "buyerExperiences": {!! json_encode($buyerExperiences ?? []) !!}
                }
            </script>
            <div class="form-section-reg-buy">
                <h2 class="section-title-reg-buy">Create Your Login Details</h2>

                <div class="field-group-reg-buy">
                    <label for="email">Email*</label>
                    <input type="email" id="email" x-model="formData.email" @blur="validateField('email')"
                        class="input-control-reg-buy" placeholder="Enter your email address">
                    <span x-show="errors.email" class="error-message"
                        style="color: #dc2626; font-size: 14px; margin-top: 5px; display: block;"
                        x-text="errors.email"></span>
                </div>

                <div class="field-group-reg-buy" style="margin-bottom: 5px;">
                    <label for="password">Password*</label>
                    <div class="password-wrapper-reg-buy">
                        <input :type="showPassword ? 'text' : 'password'" id="password" x-model="formData.password"
                            @blur="validateField('password')" class="input-control-reg-buy"
                            placeholder="Create a secure password">
                        <button type="button" class="eye-icon-btn-reg-buy" id="togglePass"
                            @click="showPassword = !showPassword">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="password-hint-reg-buy">
                        <span>i</span> Must contain at least 1 upper case letter, 1 lower case letter, 1 number and be
                        longer than 8 characters
                    </div>
                    <span x-show="errors.password" class="error-message"
                        style="color: #dc2626; font-size: 14px; margin-top: 5px; display: block;"
                        x-text="errors.password"></span>
                </div>
            </div>

            <div class="form-section-reg-buy">
                <h2 class="section-title-reg-buy">Your Details</h2>

                <div class="form-grid-2-reg-buy">
                    <div class="field-group-reg-buy">
                        <label for="firstname">First name*</label>
                        <input type="text" id="firstname" x-model="formData.firstname" @blur="validateField('firstname')"
                            class="input-control-reg-buy" placeholder="First name">
                        <span x-show="errors.firstname" class="error-message"
                            style="color: #dc2626; font-size: 14px; margin-top: 5px; display: block;"
                            x-text="errors.firstname"></span>
                    </div>
                    <div class="field-group-reg-buy">
                        <label for="lastname">Last name*</label>
                        <input type="text" id="lastname" x-model="formData.lastname" @blur="validateField('lastname')"
                            class="input-control-reg-buy" placeholder="Last name">
                        <span x-show="errors.lastname" class="error-message"
                            style="color: #dc2626; font-size: 14px; margin-top: 5px; display: block;"
                            x-text="errors.lastname"></span>
                    </div>

                    <div class="field-group-reg-buy full-width-reg-buy">
                        <label for="phone">Phone number*</label>
                        <div class="phone-input-wrapper-reg-buy">
                            <select class="select-control-reg-buy phone-code-reg-buy" x-model="formData.phoneCode">
                                <option value="+1">+1</option>
                                <option value="+44">+44</option>
                                <option value="+61">+61</option>
                            </select>
                            <input type="tel" id="phone" x-model="formData.phone" @blur="validateField('phone')"
                                class="input-control-reg-buy" placeholder="Phone number">
                        </div>
                        <span x-show="errors.phone" class="error-message"
                            style="color: #dc2626; font-size: 14px; margin-top: 5px; display: block;"
                            x-text="errors.phone"></span>
                    </div>

                    <div class="field-group-reg-buy full-width-reg-buy">
                        <label for="country">Country*</label>
                        <select id="country" x-model="formData.country" @blur="validateField('country')"
                            class="select-control-reg-buy">
                            <option value="">Select Country</option>
                            <template x-for="country in dynamicData.countries" :key="country.id">
                                <option :value="country.id" x-text="country.name"></option>
                            </template>
                        </select>
                        <span x-show="errors.country" class="error-message"
                            style="color: #dc2626; font-size: 14px; margin-top: 5px; display: block;"
                            x-text="errors.country"></span>
                    </div>
                </div>
            </div>

            <div class="form-section-reg-buy">
                <h2 class="section-title-reg-buy">Buyer Type Details</h2>

                <div class="field-group-reg-buy">
                    <label for="buyer-type">Select your buyer type*</label>
                    <select id="buyer-type" x-model="formData.buyerType" @blur="validateField('buyerType')"
                        class="select-control-reg-buy">
                        <option value="">Select...</option>
                        <template x-for="type in dynamicData.buyerTypes" :key="type.id">
                            <option :value="type.id" x-text="type.name"></option>
                        </template>
                    </select>
                    <span x-show="errors.buyerType" class="error-message"
                        style="color: #dc2626; font-size: 14px; margin-top: 5px; display: block;"
                        x-text="errors.buyerType"></span>
                </div>

                <div class="field-group-reg-buy">
                    <label for="buyer-exp">Select your buyer experience*</label>
                    <select id="buyer-exp" x-model="formData.buyerExp" @blur="validateField('buyerExp')"
                        class="select-control-reg-buy">
                        <option value="">Select...</option>
                        <template x-for="experience in dynamicData.buyerExperiences" :key="experience.id">
                            <option :value="experience.id" x-text="experience.name"></option>
                        </template>
                    </select>
                    <span x-show="errors.buyerExp" class="error-message"
                        style="color: #dc2626; font-size: 14px; margin-top: 5px; display: block;"
                        x-text="errors.buyerExp"></span>
                </div>
            </div>

            <div class="form-section-reg-buy">
                <div class="notification-container-reg-buy">
                    <div class="notification-header-row-reg-buy">
                        <span class="notification-title-reg-buy">Receive newsletters, offers and updates</span>
                        <span class="info-bubble-reg-buy">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="checkbox-options-group-reg-buy">
                        <label class="custom-checkbox-label-reg-buy">
                            <input type="checkbox" name="newsletter" value="email" x-model="formData.newsletter"> By Email
                        </label>
                    </div>
                </div>

                <div class="notification-container-reg-buy" style="margin-top: 25px;">
                    <div class="notification-header-row-reg-buy">
                        <span class="notification-title-reg-buy">Receive emails from carefully selected third
                            parties.</span>
                        <span class="info-bubble-reg-buy">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="checkbox-options-group-reg-buy">
                        <label class="custom-checkbox-label-reg-buy">
                            <input type="checkbox" name="third-party" value="yes" x-model="formData.thirdParty"> Yes,
                            Please
                        </label>
                    </div>
                </div>

            </div>

            <!-- Success/Error Messages -->
            <div x-show="successMessage" class="success-message-reg-buy"
                style="background-color: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 15px; border-radius: 4px; margin-bottom: 20px; display: none;">
                <strong>Success!</strong> <span x-text="successMessage"></span>
            </div>
            <div x-show="generalError" class="error-message-reg-buy"
                style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px; border-radius: 4px; margin-bottom: 20px; display: none;">
                <strong>Error!</strong> <span x-text="generalError"></span>
            </div>

            <div class="form-actions-reg-buy">
                <button type="submit" class="btn-submit-reg-buy" :disabled="isLoading"
                    :style="isLoading ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                    <span x-show="!isLoading">Continue</span>
                    <span x-show="isLoading">Processing...</span>
                </button>
            </div>

        </form>
    </div>

      <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('buyerRegistration', () => ({
                showPassword: false,
                isLoading: false,
                successMessage: '',
                generalError: '',

                // Store dynamic data
                dynamicData: {
                    countries: [],
                    buyerTypes: [],
                    buyerExperiences: []
                },

                formData: {
                    email: '',
                    password: '',
                    firstname: '',
                    lastname: '',
                    phone: '',
                    phoneCode: '+1',
                    country: '',
                    buyerType: '',
                    buyerExp: '',
                    newsletter: false,
                    thirdParty: false
                },

                errors: {
                    email: '',
                    password: '',
                    firstname: '',
                    lastname: '',
                    phone: '',
                    country: '',
                    buyerType: '',
                    buyerExp: ''
                },

                // Initialize dynamic data
                init() {
                    const dataElement = document.getElementById('registration-data');
                    if (dataElement) {
                        try {
                            const jsonData = JSON.parse(dataElement.textContent);
                            this.dynamicData.countries = jsonData.countries || [];
                            this.dynamicData.buyerTypes = jsonData.buyerTypes || [];
                            this.dynamicData.buyerExperiences = jsonData.buyerExperiences || [];
                        } catch (e) {
                            console.error('Failed to parse registration data:', e);
                        }
                    }
                },

                // Validation patterns
                patterns: {
                    email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                    password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/,
                    phone: /^\d{7,}$/,
                    name: /^[a-zA-Z\s'-]{2,}$/
                },

                // Field validation
                validateField(field) {
                    this.errors[field] = '';

                    switch (field) {
                        case 'email':
                            if (!this.formData.email) {
                                this.errors.email = 'Email is required';
                            } else if (!this.patterns.email.test(this.formData.email)) {
                                this.errors.email = 'Please enter a valid email address';
                            }
                            break;

                        case 'password':
                            if (!this.formData.password) {
                                this.errors.password = 'Password is required';
                            } else if (!this.patterns.password.test(this.formData.password)) {
                                this.errors.password =
                                    'Password must contain uppercase, lowercase, number and be at least 8 characters';
                            }
                            break;

                        case 'firstname':
                            if (!this.formData.firstname) {
                                this.errors.firstname = 'First name is required';
                            } else if (!this.patterns.name.test(this.formData.firstname)) {
                                this.errors.firstname = 'First name must be at least 2 characters';
                            }
                            break;

                        case 'lastname':
                            if (!this.formData.lastname) {
                                this.errors.lastname = 'Last name is required';
                            } else if (!this.patterns.name.test(this.formData.lastname)) {
                                this.errors.lastname = 'Last name must be at least 2 characters';
                            }
                            break;

                        case 'phone':
                            if (!this.formData.phone) {
                                this.errors.phone = 'Phone number is required';
                            } else if (!this.patterns.phone.test(this.formData.phone)) {
                                this.errors.phone = 'Please enter a valid phone number';
                            }
                            break;

                        case 'country':
                            if (!this.formData.country) {
                                this.errors.country = 'Country is required';
                            }
                            break;

                        case 'buyerType':
                            if (!this.formData.buyerType) {
                                this.errors.buyerType = 'Please select a buyer type';
                            }
                            break;

                        case 'buyerExp':
                            if (!this.formData.buyerExp) {
                                this.errors.buyerExp = 'Please select your buyer experience';
                            }
                            break;
                    }

                    return !this.errors[field];
                },

                // Validate all fields
                validateAll() {
                    let isValid = true;
                    const fieldsToValidate = ['email', 'password', 'firstname', 'lastname', 'phone',
                        'country', 'buyerType', 'buyerExp'
                    ];

                    fieldsToValidate.forEach(field => {
                        if (!this.validateField(field)) {
                            isValid = false;
                        }
                    });

                    // Scroll to first error if validation fails
                    if (!isValid) {
                        this.scrollToFirstError();
                    }

                    return isValid;
                },

                // Scroll to first error field
                scrollToFirstError() {
                    const fieldMap = {
                        email: 'email',
                        password: 'password',
                        firstname: 'firstname',
                        lastname: 'lastname',
                        phone: 'phone',
                        country: 'country',
                        buyerType: 'buyer-type',
                        buyerExp: 'buyer-exp'
                    };

                    // Find first field with error
                    for (const [errorKey, elementId] of Object.entries(fieldMap)) {
                        if (this.errors[errorKey]) {
                            const element = document.getElementById(elementId);
                            if (element) {
                                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                element.focus();
                                break;
                            }
                        }
                    }
                },

                // Form submission
                async submitForm() {
                    this.successMessage = '';
                    this.generalError = '';

                    // Validate all fields
                    if (!this.validateAll()) {
                        this.generalError = 'Please fix all errors before submitting';
                        return;
                    }

                    this.isLoading = true;

                    try {
                        const response = await fetch('{{ route('buyer.registration.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]')?.content || '',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                email: this.formData.email,
                                password: this.formData.password,
                                firstname: this.formData.firstname,
                                lastname: this.formData.lastname,
                                phone: this.formData.phoneCode + this.formData.phone,
                                country: this.formData.country,
                                buyer_type: this.formData.buyerType,
                                buyer_experience: this.formData.buyerExp,
                                newsletter: this.formData.newsletter,
                                third_party_emails: this.formData.thirdParty
                            })
                        });

                        const result = await response.json();

                        if (!response.ok) {
                            // Handle validation errors from server
                            if (result.errors) {
                                Object.keys(result.errors).forEach(field => {
                                    this.errors[field] = result.errors[field][0];
                                });
                                this.generalError = 'Please fix the errors and try again';
                                // Scroll to first error after server validation fails
                                this.$nextTick(() => {
                                    this.scrollToFirstError();
                                });
                            } else {
                                this.generalError = result.message ||
                                    'An error occurred during registration';
                            }
                        } else {
                            this.successMessage = result.message ||
                                'Registration successful! Redirecting...';

                            // Redirect after 2 seconds
                            setTimeout(() => {
                                if (result.redirect_url) {
                                    window.location.href = result.redirect_url;
                                } else {
                                    window.location.href = '/';
                                }
                            }, 2000);
                        }
                    } catch (error) {
                        this.generalError = 'Network error: ' + error.message;
                        console.error('Registration error:', error);
                    } finally {
                        this.isLoading = false;
                    }
                }
            }));
        });
    </script>
@endsection

  

