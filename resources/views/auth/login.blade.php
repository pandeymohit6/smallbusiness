@extends('auth.layouts.app')

@section('title')
    {{ $pageTitle ?? __('Sign In') }} | {{ config('app.name') }}
@endsection

@section('content')
<div>

    {{-- Header --}}
    <div class="mb-4 text-center">
        <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
            {{ $pageTitle ?? __('Sign In') }}
        </h1>

        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            {{ $pageDescription ?? __('Enter your credentials to continue') }}
        </p>
    </div>

    {!! Hook::applyFilters(AuthFilterHook::LOGIN_FORM_BEFORE, '') !!}

    <form
        action="{{ request()->url() }}"
        method="POST"

        x-data="{
            loading:false,
            errors:{},

            validateAndSubmit() {

                this.errors = {};

                if (!this.$refs.email.value.trim()) {
                    this.errors.email = 'Email is required';
                }

                if (!this.$refs.password.value.trim()) {
                    this.errors.password = 'Password is required';
                }

                if (Object.keys(this.errors).length) {
                    return;
                }

                this.loading = true;
                this.$el.submit();
            }
        }"

        @submit.prevent="validateAndSubmit()"
    >
        @csrf

        <div class="space-y-4">

            <x-messages />

            {!! Hook::applyFilters(AuthFilterHook::LOGIN_FORM_FIELDS_BEFORE_EMAIL, '') !!}

            {{-- Email --}}
            <div>
                <label class="form-label" for="email">
                    {{ __('Email') }}
                </label>

                <input
                    x-ref="email"
                    autofocus
                    type="email"
                    id="email"
                    name="email"
                    autocomplete="username"
                    placeholder="{{ __('Enter your email') }}"
                    value="{{ old('email') }}"
                    @input="delete errors.email"
                    class="form-control
                        @error('email') border-red-500 ring-red-500 @enderror"
                />

                {{-- Alpine Error --}}
                <p
                    x-show="errors.email"
                    x-text="errors.email"
                    class="mt-1 text-sm text-red-500"
                ></p>

                {{-- Laravel Error --}}
                @error('email')
                    <span class="mt-1 block text-sm text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {!! Hook::applyFilters(AuthFilterHook::LOGIN_FORM_FIELDS_AFTER_EMAIL, '') !!}
            {!! Hook::applyFilters(AuthFilterHook::LOGIN_FORM_FIELDS_BEFORE_PASSWORD, '') !!}

            {{-- Password --}}
            <div>

                <label class="form-label" for="password">
                    {{ __('Password') }}
                </label>

                <input
                    x-ref="password"
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="current-password"
                    placeholder="{{ __('Enter your password') }}"
                    @input="delete errors.password"
                    class="form-control
                        @error('password') border-red-500 ring-red-500 @enderror"
                />

                {{-- Alpine Error --}}
                <p
                    x-show="errors.password"
                    x-text="errors.password"
                    class="mt-1 text-sm text-red-500"
                ></p>

                {{-- Laravel Error --}}
                @error('password')
                    <span class="mt-1 block text-sm text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {!! Hook::applyFilters(AuthFilterHook::LOGIN_FORM_FIELDS_AFTER_PASSWORD, '') !!}

            {{-- Remember + Forgot --}}
            <div class="flex items-center justify-between">

                <label
                    for="remember"
                    class="flex items-center gap-2 cursor-pointer"
                >
                    <input
                        id="remember"
                        name="remember"
                        type="checkbox"
                        class="form-checkbox"
                        {{ old('remember') ? 'checked' : '' }}
                    >

                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Remember me') }}
                    </span>
                </label>

                @if($showForgotPassword ?? true)
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm text-brand-600 hover:text-brand-700 dark:text-brand-400"
                    >
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-recaptcha page="login" />

            {!! Hook::applyFilters(AuthFilterHook::LOGIN_FORM_FIELDS_BEFORE_SUBMIT, '') !!}

            {{-- Submit --}}
            <div>
                <button
                    type="submit"
                    class="btn-primary w-full"
                    :disabled="loading"
                >
                    <span x-show="!loading">
                        {{ __('Sign In') }}
                    </span>

                    <iconify-icon
                        x-show="loading"
                        icon="lucide:loader-circle"
                        class="animate-spin"
                    ></iconify-icon>

                    <iconify-icon
                        x-show="!loading"
                        icon="lucide:log-in"
                        class="ml-2"
                    ></iconify-icon>
                </button>
            </div>

            {!! Hook::applyFilters(AuthFilterHook::LOGIN_FORM_FIELDS_AFTER_SUBMIT, '') !!}

            {{-- Register --}}
            @if($showRegistrationLink ?? false)
                <div class="text-center pt-3 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __("Don't have an account?") }}

                        <a
                            href="{{ route('register') }}"
                            class="text-brand-600 hover:text-brand-700 dark:text-brand-400 font-medium"
                        >
                            {{ __('Create one') }}
                        </a>
                    </p>
                </div>
            @endif

        </div>
    </form>

    {{-- Social Login --}}
    <div class="mt-5">
        <x-auth.social-login-buttons />
    </div>

    {!! Hook::applyFilters(AuthFilterHook::LOGIN_FORM_AFTER, '') !!}
</div>

{!! Hook::doAction(AuthActionHook::AFTER_LOGIN_FORM_RENDER) !!}
@endsection