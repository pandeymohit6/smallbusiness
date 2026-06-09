@props([
    'dividerText' => null,
])

@inject('socialAuthService', 'App\Services\SocialAuthService')

@php
    $providers = $socialAuthService->getEnabledProviders();
    $isRegisterPage = request()->routeIs('register');

    $providerClasses = [
        'google' => 'btn-google-lgo',
        'facebook' => 'btn-facebook-lgo',
        'apple' => 'btn-apple-lgo',
    ];
@endphp

@if(count($providers))

    <div class="divider-lgo">
        {{ $dividerText ?? __('or') }}
    </div>

    <div class="social-buttons-lgo">

        @foreach($providers as $provider => $config)

            <a
                @if ($isRegisterPage)
                    :href="accountType
                        ? '{{ route('social.redirect', $provider) }}?role=' + accountType
                        : 'javascript:void(0)'"

                    :class="!accountType
                        ? 'opacity-50 pointer-events-none cursor-not-allowed'
                        : ''"

                    :title="!accountType
                        ? 'Choose Buyer, Seller or Broker first'
                        : '{{ __('Continue with :provider', ['provider' => $config['name']]) }}'"
                @else
                    href="{{ route('social.redirect', $provider) }}"
                    title="{{ __('Continue with :provider', ['provider' => $config['name']]) }}"
                @endif

                class="btn-social-lgo {{ $providerClasses[$provider] ?? '' }}"
            >

                {{-- Icon --}}
                <iconify-icon
                    icon="{{ $config['icon'] }}"
                    class="social-icon-lgo"
                ></iconify-icon>

                <span>
                    {{ __('Continue with :provider', ['provider' => $config['name']]) }}
                </span>

            </a>

        @endforeach

    </div>

    @if ($isRegisterPage)
        <p
            x-show="!accountType"
            class="mt-3 text-center text-sm text-red-500"
        >
            {{ __('Please choose your account type to continue') }}
        </p>
    @endif

@endif