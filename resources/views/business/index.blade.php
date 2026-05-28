@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">{{ __('Businesses for Sale') }}</h1>
            <p class="text-muted mb-0">{{ __('Browse active listings and send enquiries to sellers.') }}</p>
        </div>
    </div>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <input name="search" class="form-control" value="{{ request('search') }}" placeholder="{{ __('Search by title, location, or keyword') }}">
        </div>
        <div class="col-md-3">
            <select name="type" class="form-select">
                <option value="">{{ __('All Types') }}</option>
                @foreach(\App\Models\Business::getBusinessTypes() as $value => $label)
                    <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="industry" class="form-select">
                <option value="">{{ __('All Industries') }}</option>
                @foreach(\App\Models\Business::getIndustries() as $value => $label)
                    <option value="{{ $value }}" @selected(request('industry') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100" type="submit">{{ __('Filter') }}</button>
        </div>
    </form>

    <div class="row g-4">
        @forelse($businesses as $business)
            <div class="col-md-6 col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="h5">{{ $business->title }}</h2>
                        <p class="text-muted small mb-2">{{ $business->location }} · {{ \App\Models\Business::getIndustries()[$business->industry] ?? $business->industry }}</p>
                        <p>{{ \Illuminate\Support\Str::limit($business->description, 140) }}</p>
                        <div class="fw-semibold mb-3">{{ number_format((float) $business->asking_price, 2) }}</div>
                        <a class="btn btn-outline-primary" href="{{ route('businesses.show', $business->slug) }}">{{ __('View Details') }}</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">{{ __('No active listings found.') }}</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $businesses->links() }}</div>
</div>
@endsection
