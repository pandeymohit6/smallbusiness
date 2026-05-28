@csrf

@if($business->exists)
    @method('PUT')
@endif

<div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
    <div class="lg:col-span-2">
        <label class="form-label" for="title">{{ __('Title') }}</label>
        <input id="title" name="title" class="form-control" value="{{ old('title', $business->title) }}" required>
        @error('title')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="form-label" for="business_type">{{ __('Business Type') }}</label>
        <select id="business_type" name="business_type" class="form-control" required>
            @foreach($businessTypes as $value => $label)
                <option value="{{ $value }}" @selected(old('business_type', $business->business_type) === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="form-label" for="industry">{{ __('Industry') }}</label>
        <select id="industry" name="industry" class="form-control" required>
            @foreach($industries as $value => $label)
                <option value="{{ $value }}" @selected(old('industry', $business->industry) === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="form-label" for="location">{{ __('Location') }}</label>
        <input id="location" name="location" class="form-control" value="{{ old('location', $business->location) }}" required>
    </div>

    <div>
        <label class="form-label" for="asking_price">{{ __('Asking Price') }}</label>
        <input id="asking_price" name="asking_price" type="number" min="0" step="0.01" class="form-control" value="{{ old('asking_price', $business->asking_price) }}" required>
    </div>

    <div>
        <label class="form-label" for="annual_revenue">{{ __('Annual Revenue') }}</label>
        <input id="annual_revenue" name="annual_revenue" type="number" min="0" step="0.01" class="form-control" value="{{ old('annual_revenue', $business->annual_revenue) }}">
    </div>

    <div>
        <label class="form-label" for="annual_profit">{{ __('Annual Profit') }}</label>
        <input id="annual_profit" name="annual_profit" type="number" min="0" step="0.01" class="form-control" value="{{ old('annual_profit', $business->annual_profit) }}">
    </div>

    <div>
        <label class="form-label" for="years_in_operation">{{ __('Years in Operation') }}</label>
        <input id="years_in_operation" name="years_in_operation" type="number" min="0" class="form-control" value="{{ old('years_in_operation', $business->years_in_operation) }}">
    </div>

    <div>
        <label class="form-label" for="employees">{{ __('Employees') }}</label>
        <input id="employees" name="employees" type="number" min="0" class="form-control" value="{{ old('employees', $business->employees) }}">
    </div>

    @if($business->exists)
        <div>
            <label class="form-label" for="status">{{ __('Status') }}</label>
            <select id="status" name="status" class="form-control" required>
                @foreach(\App\Models\Business::getStatuses() as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $business->status) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label" for="published_at">{{ __('Published At') }}</label>
            <input id="published_at" name="published_at" type="datetime-local" class="form-control" value="{{ old('published_at', optional($business->published_at)->format('Y-m-d\TH:i')) }}">
        </div>
    @endif

    <div class="lg:col-span-2">
        <label class="form-label" for="description">{{ __('Description') }}</label>
        <textarea id="description" name="description" rows="5" class="form-control" required>{{ old('description', $business->description) }}</textarea>
    </div>

    <div class="lg:col-span-2">
        <label class="form-label" for="overview">{{ __('Overview') }}</label>
        <textarea id="overview" name="overview" rows="4" class="form-control">{{ old('overview', $business->overview) }}</textarea>
    </div>

    <div>
        <label class="form-label" for="features">{{ __('Features') }}</label>
        <textarea id="features" name="features" rows="4" class="form-control">{{ old('features', $business->features) }}</textarea>
    </div>

    <div>
        <label class="form-label" for="highlights">{{ __('Highlights') }}</label>
        <textarea id="highlights" name="highlights" rows="4" class="form-control">{{ old('highlights', $business->highlights) }}</textarea>
    </div>

    @can('business.manage')
        <div class="lg:col-span-2">
            <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $business->is_featured))>
                {{ __('Featured listing') }}
            </label>
        </div>
    @endcan
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="btn-primary">{{ $business->exists ? __('Update Listing') : __('Create Listing') }}</button>
    <a href="{{ route('admin.business.index') }}" class="btn-secondary">{{ __('Cancel') }}</a>
</div>
