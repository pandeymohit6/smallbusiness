@props(['errors'])

@if ($errors->any())
    <div
        x-data="{ show: true }"
        x-show="show"
        class="mb-5 overflow-hidden rounded-xl border border-red-200 bg-white shadow-sm"
        role="alert">

        <div class="flex items-start gap-4 border-l-4 border-red-500 p-5">

            <!-- Icon -->
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
                <i class="fas fa-circle-exclamation text-xl"></i>
            </div>

            <!-- Content -->
            <div class="flex-1">

                <div class="flex items-center gap-2 mb-2">
                    <h3 class="text-base font-semibold text-red-700">
                        Validation Error
                    </h3>

                    <span
                        class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                        {{ $errors->count() }}
                        {{ $errors->count() > 1 ? 'Issues Found' : 'Issue Found' }}
                    </span>
                </div>

                <p class="mb-3 text-sm text-gray-600">
                    Please review the following and try again.
                </p>

                <ul class="space-y-2">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-start gap-2 text-sm text-gray-700">
                            <i class="fas fa-circle text-[7px] mt-[8px] text-red-500"></i>
                            <span>{!! __($error) !!}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Close -->
            <button
                type="button"
                @click="show = false"
                class="rounded-lg p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700">

                <i class="fas fa-xmark"></i>
            </button>

        </div>
    </div>
@endif