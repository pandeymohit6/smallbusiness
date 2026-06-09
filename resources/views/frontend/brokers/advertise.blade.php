@extends('frontend.layouts.app')

@section('content')
    <section class="sell-buin">
        <div class="container">
            <div class="small-busine">
                <h4>Sell more businesses with a BrokerWeb Account</h4>
                <p>Cost-effectively market your listings to a large audience of local, national and international buyers..
                </p>
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
                        Find out more
                    </h2>
                </div>

                <div class="package-body-sell" x-data="{
                    country: '',
                    error: '',
                    loading: false,
                
                    redirect() {
                        this.error = '';
                
                        if (!this.country) {
                            this.error = 'Please select a country';
                            return;
                        }
                
                        this.loading = true;
                
                        const protocol = window.location.protocol;
                        const port = window.location.port ? ':' + window.location.port : '';
                        const host = window.location.hostname;
                        const code = this.country;
                        let url;
                
                        if (host.includes('localhost')) {
                            url = `${protocol}//${this.country}.localhost${port}/${code}/advertise`;
                        } else {
                            const parts = host.split('.');
                            const rootDomain = parts.slice(-2).join('.');
                            url = `${protocol}//${this.country}.${rootDomain}/${code}/advertise`;
                        }
                
                        window.location.href = url;
                    }
                }">

                    <p class="package-text-sell">
                        Find out more. Please select your country:
                    </p>

                    <div class="selector-group-sell">

                        <select x-model="country" class="country-select-sell">
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
@endsection
