@section('title', $business->title . ' | ' . config('app.name'))

<x-layouts.backend-layout>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-700 dark:text-white/90">{{ $business->title }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $business->location }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.business.inquiries', $business) }}" class="btn-secondary">{{ __('Enquiries') }}</a>
            @can('business.edit')
                <a href="{{ route('admin.business.edit', $business) }}" class="btn-primary">{{ __('Edit') }}</a>
            @endcan
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        <div class="rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:col-span-2">
            <h3 class="mb-3 font-semibold text-gray-800 dark:text-white/90">{{ __('Description') }}</h3>
            <div class="prose max-w-none dark:prose-invert">{!! nl2br(e($business->description)) !!}</div>
            @if($business->overview)
                <h3 class="mb-3 mt-6 font-semibold text-gray-800 dark:text-white/90">{{ __('Overview') }}</h3>
                <div class="prose max-w-none dark:prose-invert">{!! nl2br(e($business->overview)) !!}</div>
            @endif
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <dl class="space-y-3 text-sm">
                <div><dt class="text-gray-500">{{ __('Price') }}</dt><dd class="font-medium text-gray-800 dark:text-white/90">{{ number_format((float) $business->asking_price, 2) }}</dd></div>
                <div><dt class="text-gray-500">{{ __('Industry') }}</dt><dd>{{ \App\Models\Business::getIndustries()[$business->industry] ?? $business->industry }}</dd></div>
                <div><dt class="text-gray-500">{{ __('Type') }}</dt><dd>{{ \App\Models\Business::getBusinessTypes()[$business->business_type] ?? $business->business_type }}</dd></div>
                <div><dt class="text-gray-500">{{ __('Status') }}</dt><dd>{{ \App\Models\Business::getStatuses()[$business->status] ?? $business->status }}</dd></div>
                <div><dt class="text-gray-500">{{ __('Owner') }}</dt><dd>{{ $business->user?->full_name ?? '-' }}</dd></div>
            </dl>
        </div>
    </div>
</x-layouts.backend-layout>
