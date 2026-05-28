@section('title', __('Business Listings') . ' | ' . config('app.name'))

<x-layouts.backend-layout>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-700 dark:text-white/90">{{ __('Business Listings') }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Add, edit, view, and manage listings.') }}</p>
        </div>
        @can('business.create')
            <a href="{{ route('admin.business.create') }}" class="btn-primary">{{ __('Add Listing') }}</a>
        @endcan
    </div>

    <x-messages />

    <form method="GET" class="mb-5 grid grid-cols-1 gap-3 md:grid-cols-3">
        <input name="search" class="form-control" value="{{ request('search') }}" placeholder="{{ __('Search listings') }}">
        <select name="status" class="form-control">
            <option value="">{{ __('All Statuses') }}</option>
            @foreach($statuses as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="btn-secondary" type="submit">{{ __('Filter') }}</button>
    </form>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-white/[0.02]">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium uppercase text-gray-500">{{ __('Listing') }}</th>
                        <th class="px-5 py-3 text-left text-xs font-medium uppercase text-gray-500">{{ __('Owner') }}</th>
                        <th class="px-5 py-3 text-left text-xs font-medium uppercase text-gray-500">{{ __('Price') }}</th>
                        <th class="px-5 py-3 text-left text-xs font-medium uppercase text-gray-500">{{ __('Status') }}</th>
                        <th class="px-5 py-3 text-left text-xs font-medium uppercase text-gray-500">{{ __('Enquiries') }}</th>
                        <th class="px-5 py-3 text-right text-xs font-medium uppercase text-gray-500">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($businesses as $business)
                        <tr>
                            <td class="px-5 py-4">
                                <div class="font-medium text-gray-800 dark:text-white/90">{{ $business->title }}</div>
                                <div class="text-sm text-gray-500">{{ $business->location }}</div>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $business->user?->full_name ?? '-' }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ number_format((float) $business->asking_price, 2) }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ \App\Models\Business::getStatuses()[$business->status] ?? $business->status }}</td>
                            <td class="px-5 py-4 text-sm">
                                <a class="text-brand-600" href="{{ route('admin.business.inquiries', $business) }}">{{ $business->inquiries_count }}</a>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a class="btn-secondary btn-sm" href="{{ route('admin.business.show', $business) }}">{{ __('View') }}</a>
                                    @can('business.edit')
                                        <a class="btn-secondary btn-sm" href="{{ route('admin.business.edit', $business) }}">{{ __('Edit') }}</a>
                                    @endcan
                                    @can('business.delete')
                                        <form method="POST" action="{{ route('admin.business.destroy', $business) }}" onsubmit="return confirm('{{ __('Delete this listing?') }}')">
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
                            <td colspan="6" class="px-5 py-8 text-center text-sm text-gray-500">{{ __('No listings found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">{{ $businesses->links() }}</div>
</x-layouts.backend-layout>
