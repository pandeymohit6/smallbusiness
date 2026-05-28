@section('title', __('Super Admin Dashboard') . ' | ' . config('app.name'))

<x-layouts.backend-layout>
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-white/90">{{ __('Super Admin Dashboard') }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Manage users, listings, enquiries, content, email, and newsletters.') }}</p>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:user-round-check',
            'icon_bg' => '#0EA5E9',
            'label' => __('Buyers'),
            'value' => $role_counts['buyers'],
            'url' => route('admin.users.index', ['role' => 'Buyer']),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:store',
            'icon_bg' => '#10B981',
            'label' => __('Sellers'),
            'value' => $role_counts['sellers'],
            'url' => route('admin.users.index', ['role' => 'Seller']),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:handshake',
            'icon_bg' => '#6366F1',
            'label' => __('Brokers'),
            'value' => $role_counts['brokers'],
            'url' => route('admin.users.index', ['role' => 'Broker']),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:users',
            'icon_bg' => 'var(--color-brand-500)',
            'label' => __('All Users'),
            'value' => $total_users,
            'url' => route('admin.users.index'),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:briefcase-business',
            'icon_bg' => '#F59E0B',
            'label' => __('Listings'),
            'value' => $business_stats['listings'],
            'url' => route('admin.business.index'),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:messages-square',
            'icon_bg' => '#EF4444',
            'label' => __('Enquiries'),
            'value' => $business_stats['enquiries'],
            'url' => route('admin.business.all-inquiries'),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:mail',
            'icon_bg' => '#14B8A6',
            'label' => __('Newsletter'),
            'value' => $newsletter_stats['subscribed'],
            'url' => route('admin.newsletter.index'),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:file-text',
            'icon_bg' => '#8B5CF6',
            'label' => __('Pages / Posts'),
            'value' => $total_posts,
            'url' => route('admin.posts.index', 'page'),
        ])
    </div>
</x-layouts.backend-layout>
