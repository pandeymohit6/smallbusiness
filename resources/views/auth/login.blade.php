@extends('frontend.layouts.app')

@section('title')
    {{ $pageTitle ?? __('Sign In') }} | {{ config('app.name') }}
@endsection

@section('content')
    <!-- Alpine JS (add if not already included in layout) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div x-data="{ isLogin: true }">

        <!-- ================= LOGIN SECTION ================= -->
        <section class="regiter-bg" x-show="isLogin" x-transition>

            <div class="login-card-lgo" x-data="{
                loading: false,
                showPassword: false,
                errors: {},
            
                validateAndSubmit() {
                    this.errors = {};
            
                    if (!this.$refs.email.value.trim()) {
                        this.errors.email = 'Email is required';
                    }
            
                    if (!this.$refs.password.value.trim()) {
                        this.errors.password = 'Password is required';
                    }
            
                    if (Object.keys(this.errors).length) return;
            
                    this.loading = true;
                    this.$el.submit();
                }
            }">

                <h1 class="card-title-lgo">
                    {{ $pageTitle ?? __('Sign In') }}
                </h1>

                <p class="text-center mb-4 text-sm text-gray-500">
                    {{ $pageDescription ?? __('Enter your credentials to continue') }}
                </p>

                <x-messages />

                <form action="{{ request()->url() }}" method="POST" @submit.prevent="validateAndSubmit()">
                    @csrf

                    <!-- EMAIL -->
                    <div class="input-group-lgo">
                        <label>Email</label>

                        <div class="input-wrapper-lgo">
                            <input x-ref="email" type="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter your email" @input="delete errors.email" class="input-field-lgo">
                        </div>

                        <p x-show="errors.email" x-text="errors.email" class="text-red-500 text-sm"></p>
                        @error('email')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- PASSWORD -->
                    <div class="input-group-lgo">
                        <label>Password</label>

                        <div class="input-wrapper-lgo">
                            <input x-ref="password" :type="showPassword ? 'text' : 'password'" name="password"
                                placeholder="Enter your password" @input="delete errors.password"
                                class="input-field-lgo input-field-pass-lgo">

                            <div class="eye-icon-lgo cursor-pointer" @click="showPassword = !showPassword">
                                👁
                            </div>
                        </div>

                        <p x-show="errors.password" x-text="errors.password" class="text-red-500 text-sm"></p>
                        @error('password')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- OPTIONS -->
                    <div class="options-row-lgo">
                        <label>
                            <input type="checkbox" name="remember">
                            Keep me logged in
                        </label>

                        <a href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    </div>

                    <x-recaptcha page="login" />

                    <!-- SUBMIT -->
                    <button type="submit" class="btn-login-lgo" :disabled="loading">
                        <span x-show="!loading">Login</span>
                        <span x-show="loading">Please wait...</span>
                    </button>
                </form>

                <x-auth.social-login-buttons-front />

                <!-- SWITCH TO REGISTER -->
                <div class="card-footer-lgo">
                    {{ __("Don't have an account?") }}
                    <a href="javascript:void(0)" class="signup-link-lgo" @click="isLogin = false">
                        Sign Up ➔
                    </a>
                </div>

            </div>
        </section>

        <!-- ================= REGISTER SECTION ================= -->
        <section class="regiter-bg" x-show="!isLogin" x-transition>

            <div class="account-wrapper-sab">

                <div class="account-header-sab">
                    <h1>Create account</h1>

                    <div class="login-prompt-sab">
                        Already have an account?
                        <a href="javascript:void(0)" class="login-link-sab" @click="isLogin = true">
                            Log in ➔
                        </a>
                    </div>
                </div>

                <div class="role-grid-sab">

                    <a href="{{ $hasCountrySubdomain ? route('country.buyer.registration', ['country' => $countryCode]) : route('buyer.registration') }}"
                        class="role-card-sab">
                        <div class="icon-box-sab"> <svg viewBox="0 0 24 24" fill="none" stroke="#1e3a8a" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg> </div>
                        <h3>Buyer</h3>
                        <p>I’m interested in buying a business</p>
                    </a>

                    <a href="{{ $hasCountrySubdomain ? route('country.sell.business', ['country' => $countryCode]) : route('sell.business') }}"
                        class="role-card-sab">
                        <div class="icon-box-sab">
                            <!-- Seller icon -->
                           <svg viewBox="0 0 24 24" fill="none" stroke="#fb8500" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                        </div>
                        <h3>Seller</h3>
                        <p>I want to sell my business</p>
                    </a>

                    <a href="{{ $hasCountrySubdomain ? route('country.broker.advertise', ['country' => $countryCode]) : route('broker.advertise') }}"
                        class="role-card-sab">
                        <div class="icon-box-sab">
                            <!-- Broker icon -->
                           <svg viewBox="0 0 24 24" fill="none" stroke="#1e3a8a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                        </div>
                        <h3>Broker</h3>
                        <p>I am a business intermediary</p>
                    </a>

                </div>
            </div>

        </section>

    </div>
@endsection
