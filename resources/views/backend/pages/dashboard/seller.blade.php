@section('title', __('Seller Dashboard') . ' | ' . config('app.name'))

<x-layouts.backend-layout>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-700 dark:text-white/90">{{ __('Seller Dashboard') }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Manage your business listings and buyer enquiries.') }}</p>
        </div>
        @can('business.create')
            <a href="{{ route('admin.business.create') }}" class="btn-primary">{{ __('Add Listing') }}</a>
        @endcan
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:briefcase-business',
            'icon_bg' => '#0EA5E9',
            'label' => __('My Listings'),
            'value' => $business_stats['listings'],
            'url' => route('admin.business.index'),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:badge-check',
            'icon_bg' => '#6366F1',
            'label' => __('Active Listings'),
            'value' => $business_stats['active_listings'],
            'url' => route('admin.business.index', ['status' => 'active']),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:messages-square',
            'icon_bg' => '#10B981',
            'label' => __('Enquiries'),
            'value' => $business_stats['enquiries'],
            'url' => route('admin.business.all-inquiries'),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:clock',
            'icon_bg' => '#F59E0B',
            'label' => __('Pending Enquiries'),
            'value' => $business_stats['pending_enquiries'],
            'url' => route('admin.business.all-inquiries', ['status' => 'pending']),
        ])
    </div>

    @can('post.view')
    <div class="mt-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12">
                @include('backend.pages.dashboard.partials.post-chart')
            </div>
        </div>
    </div>
    @endcan
</x-layouts.backend-layout>
