<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EmailSubscription;
use App\Services\EmailSubscriptionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index(Request $request, EmailSubscriptionService $subscriptionService): View
    {
        abort_unless($request->user()?->can('newsletter.view'), 403);

        $query = EmailSubscription::query();

        if ($request->filled('status')) {
            $request->input('status') === 'subscribed'
                ? $query->subscribed()
                : $query->unsubscribed();
        }

        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->input('search') . '%');
        }

        return view('backend.pages.newsletter.index', [
            'subscriptions' => $query->latest()->paginate(20)->withQueryString(),
            'stats' => $subscriptionService->getStats(),
        ]);
    }

    public function store(Request $request, EmailSubscriptionService $subscriptionService): RedirectResponse
    {
        abort_unless($request->user()?->can('newsletter.create'), 403);

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $subscriptionService->subscribe($validated['email']);

        return back()->with('success', __('Subscriber added successfully.'));
    }

    public function update(Request $request, EmailSubscription $subscription): RedirectResponse
    {
        abort_unless($request->user()?->can('newsletter.edit'), 403);

        $request->boolean('subscribed')
            ? $subscription->resubscribe()
            : $subscription->unsubscribe();

        return back()->with('success', __('Subscriber updated successfully.'));
    }

    public function destroy(Request $request, EmailSubscription $subscription): RedirectResponse
    {
        abort_unless($request->user()?->can('newsletter.delete'), 403);

        $subscription->delete();

        return back()->with('success', __('Subscriber deleted successfully.'));
    }
}
