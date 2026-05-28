<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Business;
use App\Models\BusinessInquiry;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    /**
     * Display a listing of businesses.
     */
    public function index(Request $request): View
    {
        $query = Business::query()->with('user')->withCount('inquiries');

        if (! $this->canManageAll()) {
            if (Auth::user()->hasRole(Role::SELLER)) {
                $query->where('user_id', Auth::id());
            } elseif (Auth::user()->hasAnyRole([Role::BUYER, Role::BROKER])) {
                $query->active();
            } else {
                abort(403);
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('industry', 'like', "%{$search}%");
            });
        }

        $businesses = $query->latest()->paginate(15)->withQueryString();

        return view('backend.pages.business.index', [
            'businesses' => $businesses,
            'statuses' => Business::getStatuses(),
        ]);
    }

    /**
     * Show the form for creating a new business.
     */
    public function create(): View
    {
        $this->authorizePermission('business.create');

        return view('backend.pages.business.create', [
            'business' => new Business(),
            'businessTypes' => Business::getBusinessTypes(),
            'industries' => Business::getIndustries(),
        ]);
    }

    /**
     * Store a newly created business in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'overview' => ['nullable', 'string'],
            'business_type' => ['required', 'string'],
            'industry' => ['required', 'string'],
            'location' => ['required', 'string'],
            'asking_price' => ['required', 'numeric', 'min:0'],
            'annual_revenue' => ['nullable', 'numeric', 'min:0'],
            'annual_profit' => ['nullable', 'numeric', 'min:0'],
            'years_in_operation' => ['nullable', 'integer', 'min:0'],
            'employees' => ['nullable', 'integer', 'min:0'],
            'features' => ['nullable', 'string'],
            'highlights' => ['nullable', 'string'],
            'is_featured' => ['boolean'],
        ]);

        $this->authorizePermission('business.create');

        if (! $this->canManageAll()) {
            unset($validated['is_featured']);
        }

        $validated['user_id'] = Auth::id();

        Business::create($validated);

        return redirect()->route('admin.business.index')
            ->with('success', __('Business created successfully.'));
    }

    /**
     * Display the specified business.
     */
    public function show(Business $business): View
    {
        $this->authorizeBusinessAccess($business);

        return view('backend.pages.business.show', compact('business'));
    }

    /**
     * Show the form for editing the specified business.
     */
    public function edit(Business $business): View
    {
        $this->authorizeBusinessAccess($business, 'business.edit');

        return view('backend.pages.business.edit', [
            'business' => $business,
            'businessTypes' => Business::getBusinessTypes(),
            'industries' => Business::getIndustries(),
        ]);
    }

    /**
     * Update the specified business in storage.
     */
    public function update(Request $request, Business $business): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'overview' => ['nullable', 'string'],
            'business_type' => ['required', 'string'],
            'industry' => ['required', 'string'],
            'location' => ['required', 'string'],
            'asking_price' => ['required', 'numeric', 'min:0'],
            'annual_revenue' => ['nullable', 'numeric', 'min:0'],
            'annual_profit' => ['nullable', 'numeric', 'min:0'],
            'years_in_operation' => ['nullable', 'integer', 'min:0'],
            'employees' => ['nullable', 'integer', 'min:0'],
            'features' => ['nullable', 'string'],
            'highlights' => ['nullable', 'string'],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:draft,active,sold,delisted'],
            'published_at' => ['nullable', 'date'],
        ]);

        $this->authorizeBusinessAccess($business, 'business.edit');

        if (! $this->canManageAll()) {
            unset($validated['is_featured']);
        }

        $business->update($validated);

        return redirect()->route('admin.business.show', $business)
            ->with('success', __('Business updated successfully.'));
    }

    /**
     * Delete the specified business.
     */
    public function destroy(Business $business): RedirectResponse
    {
        $this->authorizeBusinessAccess($business, 'business.delete');

        $business->delete();

        return redirect()->route('admin.business.index')
            ->with('success', __('Business deleted successfully.'));
    }

    /**
     * Display inquiries for a business.
     */
    public function inquiries(Business $business): View
    {
        $this->authorizePermission('business_inquiry.view');

        if (! $this->canManageAll()) {
            abort_unless(Auth::user()->hasRole(Role::SELLER) && $business->user_id === Auth::id(), 403);
        }

        $inquiries = $business->inquiries()
            ->with(['user', 'broker'])
            ->latest()
            ->paginate(15);

        $brokers = User::role(Role::BROKER)->orderBy('first_name')->get();

        return view('backend.pages.business.inquiries', compact('business', 'inquiries', 'brokers'));
    }

    public function allInquiries(Request $request): View
    {
        $query = BusinessInquiry::query()->with(['business.user', 'user', 'broker']);

        if (! $this->canManageAll()) {
            if (Auth::user()->hasRole(Role::SELLER)) {
                $query->whereHas('business', fn ($businessQuery) => $businessQuery->where('user_id', Auth::id()));
            } elseif (Auth::user()->hasRole(Role::BUYER)) {
                $query->where(function ($buyerQuery) {
                    $buyerQuery->where('user_id', Auth::id())
                        ->orWhere('email', Auth::user()->email);
                });
            } elseif (Auth::user()->hasRole(Role::BROKER)) {
                $query->where('broker_id', Auth::id());
            } else {
                abort(403);
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $inquiries = $query->latest()->paginate(15)->withQueryString();
        $brokers = User::role(Role::BROKER)->orderBy('first_name')->get();

        return view('backend.pages.business.inquiries', [
            'business' => null,
            'inquiries' => $inquiries,
            'brokers' => $brokers,
        ]);
    }

    /**
     * Reply to an inquiry.
     */
    public function replyInquiry(BusinessInquiry $inquiry): RedirectResponse
    {
        $this->authorizeInquiryAccess($inquiry, 'business_inquiry.reply');

        $validated = request()->validate([
            'reply_message' => ['required', 'string'],
        ]);

        $inquiry->markAsReplied($validated['reply_message']);

        return redirect()->back()
            ->with('success', __('Reply sent successfully.'));
    }

    public function updateInquiry(Request $request, BusinessInquiry $inquiry): RedirectResponse
    {
        $this->authorizeInquiryAccess($inquiry, 'business_inquiry.edit');

        $validated = $request->validate([
            'status' => ['required', 'in:pending,replied,archived'],
            'broker_id' => ['nullable', 'exists:users,id'],
        ]);

        if (! Auth::user()->can('business_inquiry.assign_broker')) {
            unset($validated['broker_id']);
        } elseif (! empty($validated['broker_id'])) {
            $broker = User::role(Role::BROKER)->findOrFail($validated['broker_id']);
            $validated['broker_id'] = $broker->id;
        }

        $inquiry->update($validated);

        return redirect()->back()->with('success', __('Inquiry updated successfully.'));
    }

    private function canManageAll(): bool
    {
        return Auth::user()->hasAnyRole([Role::SUPERADMIN, Role::ADMIN]) || Auth::user()->can('business.manage');
    }

    private function authorizePermission(string $permission): void
    {
        abort_unless(Auth::user()->can($permission), 403);
    }

    private function authorizeBusinessAccess(Business $business, string $permission = 'business.view'): void
    {
        $this->authorizePermission($permission);

        if ($this->canManageAll()) {
            return;
        }

        $user = Auth::user();

        if ($permission === 'business.view' && $user->hasAnyRole([Role::BUYER, Role::BROKER])) {
            abort_unless(
                $business->status === 'active'
                    && $business->published_at
                    && $business->published_at <= now(),
                403
            );

            return;
        }

        abort_unless($user->hasRole(Role::SELLER) && $business->user_id === $user->id, 403);
    }

    private function authorizeInquiryAccess(BusinessInquiry $inquiry, string $permission = 'business_inquiry.view'): void
    {
        $this->authorizePermission($permission);

        if ($this->canManageAll()) {
            return;
        }

        $user = Auth::user();
        $isSellerInquiry = $user->hasRole(Role::SELLER) && $inquiry->business?->user_id === $user->id;
        $isBuyerInquiry = $user->hasRole(Role::BUYER) && ($inquiry->user_id === $user->id || $inquiry->email === $user->email);
        $isBrokerInquiry = $user->hasRole(Role::BROKER) && $inquiry->broker_id === $user->id;

        abort_unless($isSellerInquiry || $isBuyerInquiry || $isBrokerInquiry, 403);
    }
}
