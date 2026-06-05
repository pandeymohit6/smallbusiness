@extends('auth.layouts.app')

@section('title')
    {{ $pageTitle ?? __('Create Account') }} | {{ config('app.name') }}
@endsection

@section('auth_card_width', 'max-w-3xl')

@section('content')
<div>

    {{-- Header --}}
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ $pageTitle ?? __('Create Account') }}
        </h1>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Already have an account?') }}

            <a
                href="{{ route('login') }}"
                class="font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400"
            >
                {{ __('Log in') }}
            </a>
        </p>
    </div>

    {!! Hook::applyFilters(AuthFilterHook::REGISTER_FORM_BEFORE, '') !!}

    <form
        action="{{ route('register') }}"
        method="POST"

        x-data="{
            loading:false,
            accountType:'{{ old('account_type', '') }}',
            errors:{}
        }"

        @submit="
            errors = {};

            if (!accountType) {
                errors.account_type = 'Choose Buyer, Seller or Broker';
            }

            if (!$refs.first_name.value.trim()) {
                errors.first_name = 'First name is required';
            }

            if (!$refs.last_name.value.trim()) {
                errors.last_name = 'Last name is required';
            }

            if (!$refs.email.value.trim()) {
                errors.email = 'Email is required';
            }

            if (!$refs.password.value.trim()) {
                errors.password = 'Password is required';
            }

            if (!$refs.password_confirmation.value.trim()) {
                errors.password_confirmation = 'Confirm password is required';
            }

            if (
                $refs.password.value &&
                $refs.password_confirmation.value &&
                $refs.password.value !== $refs.password_confirmation.value
            ) {
                errors.password_confirmation = 'Passwords do not match';
            }

            if (Object.keys(errors).length) {
                $event.preventDefault();
                return;
            }

            loading = true;
        "

        data-prevent-unsaved-changes
    >
        @csrf

        <div class="space-y-5">

            <x-messages />

            {!! Hook::applyFilters(AuthFilterHook::REGISTER_FORM_FIELDS_BEFORE, '') !!}

            {{-- Account Type --}}
            <div>

                <label class="block text-center text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('Choose Your Account Type') }}
                </label>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- Buyer --}}
                    <label
                        class="relative cursor-pointer rounded-2xl border p-5 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                        :class="accountType === 'buyer'
                            ? 'border-brand-500 bg-brand-50 shadow-lg dark:bg-brand-900/20'
                            : 'border-gray-200 dark:border-gray-700'"
                    >
                        <input
                            type="radio"
                            name="account_type"
                            value="buyer"
                            x-model="accountType"
                            @change="delete errors.account_type"
                            class="hidden"
                        >

                        <div class="flex justify-center mb-3">
                            <div
                                class="w-14 h-14 rounded-full flex items-center justify-center text-2xl"
                                :class="accountType === 'buyer'
                                    ? 'bg-brand-500 text-white'
                                    : 'bg-gray-100 dark:bg-gray-800'"
                            >
                                🛒
                            </div>
                        </div>

                        <h3 class="font-semibold text-gray-900 dark:text-white">
                            {{ __('Buyer') }}
                        </h3>

                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ __("I'm interested in buying a business") }}
                        </p>

                        <div
                            x-show="accountType === 'buyer'"
                            class="absolute top-3 right-3 text-brand-600 text-lg"
                        >
                            ✓
                        </div>
                    </label>

                    {{-- Seller --}}
                    <label
                        class="relative cursor-pointer rounded-2xl border p-5 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                        :class="accountType === 'seller'
                            ? 'border-brand-500 bg-brand-50 shadow-lg dark:bg-brand-900/20'
                            : 'border-gray-200 dark:border-gray-700'"
                    >
                        <input
                            type="radio"
                            name="account_type"
                            value="seller"
                            x-model="accountType"
                            @change="delete errors.account_type"
                            class="hidden"
                        >

                        <div class="flex justify-center mb-3">
                            <div
                                class="w-14 h-14 rounded-full flex items-center justify-center text-2xl"
                                :class="accountType === 'seller'
                                    ? 'bg-brand-500 text-white'
                                    : 'bg-gray-100 dark:bg-gray-800'"
                            >
                                💼
                            </div>
                        </div>

                        <h3 class="font-semibold text-gray-900 dark:text-white">
                            {{ __('Seller') }}
                        </h3>

                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('I want to sell my business') }}
                        </p>

                        <div
                            x-show="accountType === 'seller'"
                            class="absolute top-3 right-3 text-brand-600 text-lg"
                        >
                            ✓
                        </div>
                    </label>

                    {{-- Broker --}}
                    <label
                        class="relative cursor-pointer rounded-2xl border p-5 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                        :class="accountType === 'broker'
                            ? 'border-brand-500 bg-brand-50 shadow-lg dark:bg-brand-900/20'
                            : 'border-gray-200 dark:border-gray-700'"
                    >
                        <input
                            type="radio"
                            name="account_type"
                            value="broker"
                            x-model="accountType"
                            @change="delete errors.account_type"
                            class="hidden"
                        >

                        <div class="flex justify-center mb-3">
                            <div
                                class="w-14 h-14 rounded-full flex items-center justify-center text-2xl"
                                :class="accountType === 'broker'
                                    ? 'bg-brand-500 text-white'
                                    : 'bg-gray-100 dark:bg-gray-800'"
                            >
                                🤝
                            </div>
                        </div>

                        <h3 class="font-semibold text-gray-900 dark:text-white">
                            {{ __('Broker') }}
                        </h3>

                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('I am an intermediary / business broker') }}
                        </p>

                        <div
                            x-show="accountType === 'broker'"
                            class="absolute top-3 right-3 text-brand-600 text-lg"
                        >
                            ✓
                        </div>
                    </label>
                </div>

                <p
                    x-show="errors.account_type"
                    x-text="errors.account_type"
                    class="mt-3 text-center text-sm text-red-500"
                ></p>
            </div>

            {{-- First + Last Name --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="form-label">{{ __('First Name') }}</label>

                    <input
                        x-ref="first_name"
                        type="text"
                        name="first_name"
                        value="{{ old('first_name') }}"
                        class="form-control"
                        placeholder="{{ __('First name') }}"
                        @input="delete errors.first_name"
                    >

                    <p
                        x-show="errors.first_name"
                        x-text="errors.first_name"
                        class="text-red-500 text-sm mt-1"
                    ></p>
                </div>

                <div>
                    <label class="form-label">{{ __('Last Name') }}</label>

                    <input
                        x-ref="last_name"
                        type="text"
                        name="last_name"
                        value="{{ old('last_name') }}"
                        class="form-control"
                        placeholder="{{ __('Last name') }}"
                        @input="delete errors.last_name"
                    >

                    <p
                        x-show="errors.last_name"
                        x-text="errors.last_name"
                        class="text-red-500 text-sm mt-1"
                    ></p>
                </div>
            </div>

            {{-- Email --}}
            <div>
                <label class="form-label">{{ __('Email') }}</label>

                <input
                    x-ref="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control"
                    placeholder="{{ __('Enter your email') }}"
                    @input="delete errors.email"
                >

                <p
                    x-show="errors.email"
                    x-text="errors.email"
                    class="text-red-500 text-sm mt-1"
                ></p>
            </div>

            {{-- Password --}}
            <div>
                <label class="form-label">{{ __('Password') }}</label>

                <input
                    x-ref="password"
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="{{ __('Enter your password') }}"
                    @input="delete errors.password"
                >

                <p
                    x-show="errors.password"
                    x-text="errors.password"
                    class="text-red-500 text-sm mt-1"
                ></p>
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="form-label">{{ __('Confirm Password') }}</label>

                <input
                    x-ref="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="{{ __('Confirm your password') }}"
                    @input="delete errors.password_confirmation"
                >

                <p
                    x-show="errors.password_confirmation"
                    x-text="errors.password_confirmation"
                    class="text-red-500 text-sm mt-1"
                ></p>
            </div>

            <x-recaptcha page="registration" />

            {{-- Submit --}}
            <button
                type="submit"
                class="btn-primary w-full py-3"
                :disabled="loading"
            >
                <span x-show="!loading">
                    {{ __('Create Account') }}
                </span>

                <iconify-icon
                    x-show="loading"
                    icon="lucide:loader-circle"
                    class="animate-spin"
                ></iconify-icon>
            </button>

            {{-- Social Login --}}
            <x-auth.social-login-buttons />

        </div>
    </form>

    {!! Hook::applyFilters(AuthFilterHook::REGISTER_FORM_AFTER, '') !!}
</div>

{!! Hook::doAction(AuthActionHook::AFTER_REGISTER_FORM_RENDER) !!}
@endsection