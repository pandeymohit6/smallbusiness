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

                <div class="package-body-sell">

                    <p class="package-text-sell">
                        Find out more. Please select your country:
                    </p>

                    <form method="POST" action="{{ route('country.redirect') }}">
                        @csrf
                        <input type="hidden" name="user_type" value="seller">
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
