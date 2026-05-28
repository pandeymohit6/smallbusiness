@section('title', __('Enquiries') . ' | ' . config('app.name'))

<x-layouts.backend-layout>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-700 dark:text-white/90">{{ __('Enquiries') }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $business ? $business->title : __('Buyer, seller, and broker enquiry management') }}</p>
        </div>
        @if($business)
            <a href="{{ route('admin.business.show', $business) }}" class="btn-secondary">{{ __('Back to Listing') }}</a>
        @endif
    </div>

    <x-messages />

    <div class="space-y-4">
        @forelse($inquiries as $inquiry)
            <div class="rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <div class="font-medium text-gray-800 dark:text-white/90">{{ $inquiry->name }} <span class="text-sm text-gray-500">({{ $inquiry->email }})</span></div>
                        <div class="mt-1 text-sm text-gray-500">{{ $inquiry->business?->title }} @if($inquiry->phone) · {{ $inquiry->phone }} @endif</div>
                        <p class="mt-3 text-sm text-gray-700 dark:text-gray-300">{{ $inquiry->message }}</p>
                    </div>
                    <div class="text-sm text-gray-500">{{ \App\Models\BusinessInquiry::getStatuses()[$inquiry->status] ?? $inquiry->status }}</div>
                </div>

                @if($inquiry->reply_message)
                    <div class="mt-4 rounded-md bg-gray-50 p-3 text-sm text-gray-700 dark:bg-white/[0.04] dark:text-gray-300">
                        <strong>{{ __('Reply') }}:</strong> {{ $inquiry->reply_message }}
                    </div>
                @endif

                <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-2">
                    @can('business_inquiry.reply')
                        <form method="POST" action="{{ route('admin.business.reply-inquiry', $inquiry) }}" class="space-y-2">
                            @csrf
                            <textarea name="reply_message" class="form-control" rows="3" placeholder="{{ __('Write a reply') }}" required></textarea>
                            <button class="btn-primary" type="submit">{{ __('Send Reply') }}</button>
                        </form>
                    @endcan

                    @can('business_inquiry.edit')
                        <form method="POST" action="{{ route('admin.business.inquiries.update', $inquiry) }}" class="grid grid-cols-1 gap-2 sm:grid-cols-3">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-control">
                                @foreach(\App\Models\BusinessInquiry::getStatuses() as $value => $label)
                                    <option value="{{ $value }}" @selected($inquiry->status === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @can('business_inquiry.assign_broker')
                                <select name="broker_id" class="form-control">
                                    <option value="">{{ __('No Broker') }}</option>
                                    @foreach($brokers as $broker)
                                        <option value="{{ $broker->id }}" @selected($inquiry->broker_id === $broker->id)>{{ $broker->full_name }}</option>
                                    @endforeach
                                </select>
                            @endcan
                            <button class="btn-secondary" type="submit">{{ __('Update') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <div class="rounded-lg border border-gray-200 bg-white p-8 text-center text-sm text-gray-500 dark:border-gray-800 dark:bg-white/[0.03]">
                {{ __('No enquiries found.') }}
            </div>
        @endforelse
    </div>

    <div class="mt-5">{{ $inquiries->links() }}</div>
</x-layouts.backend-layout>
