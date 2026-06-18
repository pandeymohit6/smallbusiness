@props([
    'title' => 'Error',
    'message'
])

<div class="relative w-full mb-3 overflow-hidden" role="alert">
    <div class="flex items-start gap-3 rounded-md border border-red-200 bg-red-50 p-4 shadow-sm">

        <!-- Icon -->
        <div class="flex-shrink-0 text-red-600 text-lg">
            <i class="fas fa-circle-exclamation"></i>
        </div>

        <!-- Content -->
        <div class="flex-1">
            <h4 class="text-sm font-semibold text-red-800">
                {{ $title }}
            </h4>

            <p class="mt-1 text-sm text-red-700 leading-relaxed">
                {!! __($message) !!}
            </p>
        </div>

        <!-- Close Button -->
        <button
            type="button"
            class="flex-shrink-0 text-red-500 hover:text-red-700"
            aria-label="Dismiss"
            onclick="this.closest('[role=alert]').remove()">

            <i class="fas fa-times"></i>

        </button>

    </div>
</div>