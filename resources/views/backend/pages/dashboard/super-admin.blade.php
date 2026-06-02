@section('title', __('Super Admin Dashboard') . ' | ' . config('app.name'))
@php
    $dashboardSections = Hook::applyFilters(DashboardFilterHook::DASHBOARD_SECTIONS, [
        'quick_actions',
        'stat_cards',
        'user_growth',
        'quick_draft',
        'post_chart',
        'recent_posts',
    ]);
@endphp
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

    @section('before_vite_build')
        <script>
            var userGrowthData = @json($user_growth_data['data']);
            var userGrowthLabels = @json($user_growth_data['labels']);
        </script>
    @endsection

    {{-- Charts Row: User Growth + Quick Draft --}}
    @if(in_array('user_growth', $dashboardSections) || in_array('quick_draft', $dashboardSections))
    @can('user.view')
    <div class="mt-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            {{-- User Growth Chart --}}
            @if(in_array('user_growth', $dashboardSections))
            <div class="col-span-12 lg:col-span-8">
                @include('backend.pages.dashboard.partials.user-growth')
            </div>
            @endif
            {{-- Quick Draft Form --}}
            @if(in_array('quick_draft', $dashboardSections))
            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                @can('post.create')
                <livewire:dashboard.quick-draft />
                @endcan
            </div>
            @endif
        </div>
    </div>
    @endcan
    @endif

    {{-- Bottom Row: Post Activity + Recent Posts --}}
    @if(in_array('post_chart', $dashboardSections) || in_array('recent_posts', $dashboardSections))
    <div class="mt-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            {{-- Post Activity Chart --}}
            @if(in_array('post_chart', $dashboardSections))
            @can('post.view')
            <div class="col-span-12 lg:col-span-8">
                <div class="grid grid-cols-12 gap-4 md:gap-6">
                    @include('backend.pages.dashboard.partials.post-chart')
                </div>
            </div>
            @endcan
            @endif

            {{-- Recent Posts Sidebar --}}
            @if(in_array('recent_posts', $dashboardSections))
            <div class="col-span-12 lg:col-span-4">
                @can('post.view')
                <livewire:dashboard.recent-posts :limit="5" />
                @endcan
            </div>
            @endif
        </div>
    </div>
    @endif
</x-layouts.backend-layout>
