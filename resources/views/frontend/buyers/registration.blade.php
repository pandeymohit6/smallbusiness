@extends('frontend.layouts.app')

@section('content')
    <section class="sell-buin">
        <div class="container">
            <div class="small-busine">
                <h4>Register as a Business Buyer</h4>
                <p>
                    Sign up and join thousands of business buyers already using our platform
                    to find businesses for sale.
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
                        Flexible Packages & Tailored Advice Available
                    </h2>
                </div>

                <div class="package-body-sell">

                    <p class="package-text-sell">
                        Find out more. Please select your country:
                    </p>

                    <form method="POST" action="{{ route('country.redirect') }}">
                        <input type="hidden" name="user_type" value="buyer">
                        @csrf

                        <div class="selector-group-sell">
                            <select name="country" class="country-select-sell" required>
                                <option value="">
                                    Select country...
                                </option>

                                @foreach ($countries as $country)
                                    <option value="{{ $country->slug }}">
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="go-btn">
                                GO
                            </button>

                        </div>

                        @error('country')
                            <p class="mt-2 text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </form>

                </div>

            </div>
        </div>
    </section>
@endsection
