@extends('frontend.layouts.app')

@section('content')
    <section class="sell-buin-login">
        <div class="container">
            <div class="pricing-section-login">
                <div class="pricing-header-login">
                    <h1>Sell your business.<br>Reach 1.2 million buyers.</h1>
                    <p>Create your listing and sell with confidence. We help over 1,500 owners find the right buyer each
                        month.</p>
                    <div class="broker-link-login">Are you a broker? <a
                            href="{{ $hasCountrySubdomain ? route('broker.advertise', ['code' => $countryCode]) : route('broker.advertise') }}">Click
                            here</a></div>
                </div>

                <div class="pricing-grid-login">

                    @foreach ($plans as $plan)
                        <div class="price-card-login {{ $plan['featured'] ? 'featured-login' : '' }}" x-data="{ loading: false }">

                            @if ($plan['badge'])
                                <div class="badge">{{ $plan['badge'] }}</div>
                            @endif

                            <div class="plan-duration-login">
                                {{ $plan['duration'] }}
                            </div>

                            <div class="plan-price-login">
                                <span class="price-amount-login">${{ $plan['price'] }}</span>
                                <span class="price-currency-login">USD</span>
                            </div>

                            <div class="plan-features-login">

                                <div class="features-title-login">
                                    {{ $plan['features_title'] }}
                                </div>

                                <ul class="features-list-login">
                                    @foreach ($plan['features'] as $feature)
                                        <li>{!! $feature !!}</li>
                                    @endforeach
                                </ul>

                                <div class="features-note-login">
                                    {!! $plan['note'] !!}
                                </div>

                            </div>

                            <button type="button" class="action-btn-login"
                                @click="loading = true; window.location.href='{{ route('seller.registration.select.login', ['productCode' => $plan['code']]) }}'"
                                :disabled="loading">
                                <span x-show="!loading">{{ $plan['button'] }}</span>
                                <span x-show="loading">Redirecting...</span>
                            </button>

                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </section>

    <section>
        <div class="container">
            <div class="how-it-works-section-how">

                <div class="section-title-wrapper-how">
                    <h2 class="section-title-how">How it works</h2>
                    <div class="title-line-how"></div>
                </div>

                <div class="steps-grid-how">

                    <div class="step-card-how">
                        <div class="step-number-how">1</div>
                        <h3 class="step-title-how">Select your package</h3>
                        <p class="step-desc-how">Choose to advertise your business for 1, 3 or 6 months.</p>
                    </div>


                    <div class="step-card-how">
                        <div class="step-number-how">2</div>
                        <h3 class="step-title-how">Create your listing</h3>
                        <p class="step-desc-how">Add as much information as you like, including photos and other documents,
                            in our easy to use listing builder.</p>
                    </div>


                    <div class="step-card-how">
                        <div class="step-number-how">3</div>
                        <h3 class="step-title-how">Review your interested buyers</h3>
                        <p class="step-desc-how">Buyers will email you directly through the website.</p>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <section class="bg-light">
        <div class="container">
            <div class="features-section-why">
                <div class="title-wrapper-why">
                    <h2 class="main-title-why">Why sell a business with us?</h2>
                    <div class="title-accent-line-why"></div>
                </div>
                <div class="features-grid-why">

                    <div class="feature-card-why">
                        <div class="icon-container-why">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#1e3a8a" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <h3 class="feature-title-why">Reach 1.2 million buyers</h3>
                        <p class="feature-desc-why">There are many variations of passages of Lorem Ipsum available, but the
                            majority have suffered alteration in some form, by injected humour, or randomised words which
                            don't look even slightly believable. </p>
                    </div>

                    <div class="feature-card-why">
                        <div class="icon-container-why">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#fb8500" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                <line x1="12" y1="4" x2="12" y2="20"></line>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </div>
                        <h3 class="feature-title-why">Save money – pay no commission</h3>
                        <p class="feature-desc-why">No commission or hidden charges. Choose a package and only pay the one
                            off fee. You can cancel anytime without penalty.</p>
                    </div>

                    <div class="feature-card-why">
                        <div class="icon-container-why">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#1e3a8a" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <h3 class="feature-title-why">Easy to use - it takes 10 minutes!</h3>
                        <p class="feature-desc-why">There are many variations of passages of Lorem Ipsum available, but the
                            majority have suffered alteration in some form, by injected humour</p>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <section class="bg-light2">
        <div class="container">
            <div class="about-us-section">
                <div class="about-us-container">

                    <div class="col-md-8">
                        <h2 class="section-title_pop" style="font-size: 36px!important;">About Us</h2>

                        <p class="about-text">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                            the industry's standard dummy text ever since 1966, when designers at Letraset and James Mosley
                        </p>

                        <p class="about-text">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                            the industry's standard dummy text ever since 1966, when designers at Letraset and James Mosley,
                            the librarian at St Bride Printing Library, took a 1914 Cicero translation and scrambled it to
                            make dummy text for Letraset's Body Type sheets.
                        </p>

                        <p class="about-text">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                            the industry's standard dummy text ever since 1966, when designers at Letraset and James Mosley
                        </p>

                        <p class="about-text font-bold">
                            We're always looking to improve the site and our service so if you have any feedback or you are
                            looking to sell your business, we'd love to hear from you. <a href="{{ route('contact') }}"
                                class="contact-link">Contact Us.</a>
                        </p>
                    </div>

                    <div class="col-md-4">
                        <div class="image-wrapper">
                            <img src="https://digitalelixirr.com/sales/assets/img/franch.jpg"
                                alt="Small Business Growth Ecosystem">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('redirectButton', () => ({
                loading: false,

                redirect(event) {
                    this.loading = true;
                }
            }));
        });
    </script>
@endsection
