@section('title', __('Edit Listing') . ' | ' . config('app.name'))

<x-layouts.backend-layout>
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-white/90">{{ __('Edit Listing') }}</h2>
    </div>

    <x-messages />

    <form method="POST" action="{{ route('admin.business.update', $business) }}" class="rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        @include('backend.pages.business.partials.form')
    </form>
</x-layouts.backend-layout>
