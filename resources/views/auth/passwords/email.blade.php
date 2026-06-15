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

            <div class="login-card-lgo">
                {{-- Header --}}
                <div class="mb-4 text-center">
                    <div
                        class="mx-auto w-10 h-10 bg-brand-100 dark:bg-brand-900/30 rounded-full flex items-center justify-center mb-2">
                        <iconify-icon icon="lucide:key-round"
                            class="text-lg text-brand-600 dark:text-brand-400"></iconify-icon>
                    </div>
                    <h1 class="card-title-lgo">
                        {{ __('Reset Password') }}
                    </h1>
                    <p class="text-center mb-4 text-sm text-gray-500">
                        {{ __('Enter your email to receive a reset link') }}
                    </p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" x-data="forgotPasswordForm()"
                    @submit.prevent="submitForm">
                    @csrf

                    <div class="space-y-4">

                        <!-- Email -->
                        <div class="input-group-lgo">
                            <label>{{ __('Email') }}</label>

                            <div class="input-wrapper-lgo">
                                <input type="email" id="email" name="email" x-model="email" @blur="validateEmail"
                                    placeholder="{{ __('Enter your email') }}" class="form-control"
                                    :class="{ 'border-red-500': errors.email }" />

                               
                            </div>
                             <!-- Alpine Validation -->
                                <p x-show="errors.email" x-text="errors.email" class="text-red-500 text-sm mt-1"></p>

                                <!-- Laravel Validation -->
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror
                        </div>

                        <x-recaptcha page="forgot_password" />

                        <!-- Submit -->
                        <div>
                            <button type="submit" class="btn-login-lgo" :disabled="loading">

                                <span x-show="!loading">
                                    {{ __('Send Reset Link') }}
                                </span>

                                <span x-show="loading">
                                    Sending...
                                </span>
                            </button>
                        </div>

                        <div class="card-footer-lgo">
                            <a href="{{ route('login') }}">
                                <iconify-icon icon="lucide:arrow-left"></iconify-icon>
                                {{ __('Back to login') }}
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </section>

        <script>
            function forgotPasswordForm() {
                return {
                    email: '{{ old('email') }}',
                    loading: false,

                    errors: {},

                    validateEmail() {
                        this.errors.email = '';

                        if (!this.email.trim()) {
                            this.errors.email = 'Email is required';
                            return false;
                        }

                        const emailRegex =
                            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                        if (!emailRegex.test(this.email)) {
                            this.errors.email =
                                'Please enter a valid email address';
                            return false;
                        }

                        return true;
                    },

                    validateForm() {
                        this.errors = {};

                        const emailValid = this.validateEmail();

                        return emailValid;
                    },

                    submitForm(event) {

                        if (!this.validateForm()) {

                            const firstError = document.querySelector(
                                '.text-red-500'
                            );

                            if (firstError) {
                                firstError.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }

                            return;
                        }

                        this.loading = true;

                        event.target.submit();
                    }
                }
            }
        </script>

    </div>
@endsection
