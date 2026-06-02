@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row g-4">
        <div class="col-lg-8">
            <a href="{{ route('businesses.index') }}" class="btn btn-link px-0">{{ __('Back to listings') }}</a>
            <h1 class="h3">{{ $business->title }}</h1>
            <p class="text-muted">
                {{ format_location($business->country_code, $business->state, $business->city) }}
                · {{ \App\Models\Business::getBusinessTypes()[$business->business_type] ?? $business->business_type }}
            </p>

            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="h5">{{ __('Description') }}</h2>
                    <p>{!! nl2br(e($business->description)) !!}</p>
                    @if($business->overview)
                        <h2 class="h5 mt-4">{{ __('Overview') }}</h2>
                        <p>{!! nl2br(e($business->overview)) !!}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="h5">{{ __('Listing Snapshot') }}</h2>
                    <dl class="mb-0">
                        <dt>{{ __('Location') }}</dt>
                        <dd>{{ format_location($business->country_code, $business->state, $business->city) }}</dd>
                        <dt>{{ __('Asking Price') }}</dt>
                        <dd>{{ number_format((float) $business->asking_price, 2) }}</dd>
                        <dt>{{ __('Annual Revenue') }}</dt>
                        <dd>{{ $business->annual_revenue ? number_format((float) $business->annual_revenue, 2) : '-' }}</dd>
                        <dt>{{ __('Annual Profit') }}</dt>
                        <dd>{{ $business->annual_profit ? number_format((float) $business->annual_profit, 2) : '-' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2 class="h5">{{ __('Send Enquiry') }}</h2>
                    <x-messages />
                    <form method="POST" action="{{ route('businesses.inquiry', $business) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Name') }}</label>
                            <input name="name" class="form-control" value="{{ old('name', auth()->user()?->full_name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Email') }}</label>
                            <input name="email" type="email" class="form-control" value="{{ old('email', auth()->user()?->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Phone') }}</label>
                            <input name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Message') }}</label>
                            <textarea name="message" rows="4" class="form-control" required>{{ old('message') }}</textarea>
                        </div>
                        <button class="btn btn-primary w-100" type="submit">{{ __('Submit Enquiry') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
