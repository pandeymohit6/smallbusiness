@extends('frontend.layouts.app')

@section('content')
    <section class="sell-busin-1">
        <div class="container">

          <div class="package-container-sell"
     x-data="redirectHandler()">

    <button type="button"
            class="go-btn"
            @click="redirect()"
            :disabled="loading">

        <span x-show="!loading">
            Start your 30 day FREE TRIAL today
        </span>

        <span x-show="loading">
            Redirecting...
        </span>

    </button>

    <p x-show="error" x-text="error" class="text-red-500 mt-2"></p>
</div>

<script>
function redirectHandler() {
    return {
        loading: false,
        error: '',

        redirect() {
            this.error = '';
            this.loading = true;

            const pathParts = window.location.pathname.split('/');

            // "/ca/advertise" → ["", "ca", "advertise"]
            const countryCode = pathParts[1];

            if (!countryCode) {
                this.error = 'Country code not found in URL';
                this.loading = false;
                return;
            }

            // SAFE redirect
            const url = `/${countryCode}/broker-registration-select-login-type`;

            window.location.href = url;
        }
    }
}
</script>

        </div>
    </section>
@endsection
