@section('title', __('Broker Dashboard') . ' | ' . config('app.name'))

<x-layouts.backend-layout>
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-white/90">{{ __('Broker Dashboard') }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Coordinate assigned enquiries between buyers and sellers.') }}</p>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:briefcase-business',
            'icon_bg' => '#0EA5E9',
            'label' => __('Active Listings'),
            'value' => $business_stats['active_listings'],
            'url' => route('admin.business.index'),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:handshake',
            'icon_bg' => '#10B981',
            'label' => __('Assigned Enquiries'),
            'value' => $business_stats['enquiries'],
            'url' => route('admin.business.all-inquiries'),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:clock',
            'icon_bg' => '#F59E0B',
            'label' => __('Pending Follow Ups'),
            'value' => $business_stats['pending_enquiries'],
            'url' => route('admin.business.all-inquiries', ['status' => 'pending']),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:users',
            'icon_bg' => '#6366F1',
            'label' => __('Marketplace Users'),
            'value' => $role_counts['buyers'] . ' / ' . $role_counts['sellers'],
            'url' => route('admin.business.all-inquiries'),
        ])
    </div>
</x-layouts.backend-layout>
