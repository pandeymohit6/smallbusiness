@section('title', __('Newsletter') . ' | ' . config('app.name'))

<x-layouts.backend-layout>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-700 dark:text-white/90">{{ __('Newsletter Management') }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Manage subscribed and unsubscribed email contacts.') }}</p>
        </div>
    </div>

    <x-messages />

    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:mail',
            'icon_bg' => '#0EA5E9',
            'label' => __('Total Subscribers'),
            'value' => number_format($stats['total']),
            'url' => route('admin.newsletter.index'),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:mail-check',
            'icon_bg' => '#10B981',
            'label' => __('Subscribed'),
            'value' => number_format($stats['subscribed']),
            'url' => route('admin.newsletter.index', ['status' => 'subscribed']),
        ])
        @include('backend.pages.dashboard.partials.card', [
            'icon' => 'lucide:mail-x',
            'icon_bg' => '#EF4444',
            'label' => __('Unsubscribed'),
            'value' => number_format($stats['unsubscribed']),
            'url' => route('admin.newsletter.index', ['status' => 'unsubscribed']),
        ])
    </div>

    @can('newsletter.create')
        <form method="POST" action="{{ route('admin.newsletter.store') }}" class="mb-5 grid grid-cols-1 gap-3 md:grid-cols-[1fr_auto]">
            @csrf
            <input name="email" type="email" class="form-control" placeholder="{{ __('Add subscriber email') }}" required>
            <button class="btn-primary" type="submit">{{ __('Add Subscriber') }}</button>
        </form>
    @endcan

    <form method="GET" class="mb-5 grid grid-cols-1 gap-3 md:grid-cols-3">
        <input name="search" class="form-control" value="{{ request('search') }}" placeholder="{{ __('Search email') }}">
        <select name="status" class="form-control">
            <option value="">{{ __('All Statuses') }}</option>
            <option value="subscribed" @selected(request('status') === 'subscribed')>{{ __('Subscribed') }}</option>
            <option value="unsubscribed" @selected(request('status') === 'unsubscribed')>{{ __('Unsubscribed') }}</option>
        </select>
        <button class="btn-secondary" type="submit">{{ __('Filter') }}</button>
    </form>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-white/[0.02]">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium uppercase text-gray-500">{{ __('Email') }}</th>
                        <th class="px-5 py-3 text-left text-xs font-medium uppercase text-gray-500">{{ __('Status') }}</th>
                        <th class="px-5 py-3 text-left text-xs font-medium uppercase text-gray-500">{{ __('Unsubscribed At') }}</th>
                        <th class="px-5 py-3 text-right text-xs font-medium uppercase text-gray-500">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($subscriptions as $subscription)
                        <tr>
                            <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-200">{{ $subscription->email }}</td>
                            <td class="px-5 py-4 text-sm">
                                <span class="badge {{ $subscription->subscribed ? 'badge-success' : 'badge-danger' }}">
                                    {{ $subscription->subscribed ? __('Subscribed') : __('Unsubscribed') }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ optional($subscription->unsubscribed_at)->format('Y-m-d H:i') ?? '-' }}</td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    @can('newsletter.edit')
                                        <form method="POST" action="{{ route('admin.newsletter.update', $subscription) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="subscribed" value="{{ $subscription->subscribed ? 0 : 1 }}">
                                            <button class="btn-secondary btn-sm" type="submit">
                                                {{ $subscription->subscribed ? __('Unsubscribe') : __('Resubscribe') }}
                                            </button>
                                        </form>
                                    @endcan
                                    @can('newsletter.delete')
                                        <form method="POST" action="{{ route('admin.newsletter.destroy', $subscription) }}" onsubmit="return confirm('{{ __('Delete this subscriber?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-danger btn-sm" type="submit">{{ __('Delete') }}</button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-sm text-gray-500">{{ __('No subscribers found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">{{ $subscriptions->links() }}</div>
</x-layouts.backend-layout>
