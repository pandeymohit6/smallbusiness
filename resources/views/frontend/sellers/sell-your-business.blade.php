@extends('frontend.layouts.app')

@section('content')
    <section class="sell-buin">
        <div class="container">
            <div class="small-busine">
                <h4>Selling a business? We can help you</h4>
                <p>We have been helping people buy and sell businesses online since 1996.</p>
            </div>
        </div>
    </section>

    <section class="sell-busin-1">
        <div class="container">
            <div class="package-container-sell">

                <div class="package-header-sell">
                    <div class="stars-icon-sell">
                        <span>★</span>
                        <span>★</span>
                        <span>★</span>
                    </div>

                    <h2 class="package-title-sell">
                        Flexible packages and tailored advice available
                    </h2>
                </div>

                <div class="package-body-sell" x-data="countryRedirect()">

                    <p class="package-text-sell">
                        Find out more. Please select your country:
                    </p>

                    <div class="selector-group-sell">

                        <select x-model="selectedCountry" disabled:!selectedCountry class="country-select-sell">
                            <option value="">
                                Select country...
                            </option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->slug }}">
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="button" class="go-btn" @click="redirect()" :disabled="loading">
                            <span x-show="!loading">
                                GO
                            </span>

                            <span x-show="loading">
                                Redirecting...
                            </span>
                        </button>

                    </div>

                    <p x-show="error" x-text="error" class="mt-2 text-red-500"></p>

                </div>

            </div>
        </div>
    </section>

   <script>
document.addEventListener('alpine:init', () => {
    Alpine.data('countryRedirect', () => ({
        selectedCountry: '',
        loading: false,
        error: '',
        init() {
            this.selectedCountry = this.getSubdomain();
        },
        getSubdomain() {
            return window.location.hostname.split('.')[0];
        },

        redirect() {
            this.loading = true;
            const countryCode = this.selectedCountry;
            const subdomain = this.getSubdomain();
            let url;
            if (window.location.hostname.includes('localhost')) {
                url = `http://${countryCode}.localhost:8000/${countryCode}/sell-your-business`;
            }
            else {
                const parts = window.location.hostname.split('.');
                const rootDomain = parts.slice(-2).join('.');
                url = `https://${countryCode}.${rootDomain}/${countryCode}/sell-your-business`;
            }

            window.location.href = url;
        }

    }));
});
</script>
@endsection
