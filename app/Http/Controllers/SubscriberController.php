<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\EmailSubscription;
use App\Services\EmailSubscriptionService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;

class SubscriberController extends Controller
{
    public function __construct(
        private EmailSubscriptionService $subscriptionService
    ) {
    }

    public function unsubscribe(string $encryptedEmail): View
    {
        $result = $this->subscriptionService->processUnsubscribe($encryptedEmail);

        return view('unsubscribe.result', [
            'success' => $result['success'],
            'message' => $result['message'],
            'email' => $result['email'],
        ]);
    }

    public function confirm(string $encryptedEmail): View
    {
        try {
            $email = Crypt::decryptString($encryptedEmail);

            return view('unsubscribe.confirm', [
                'email' => $email,
                'encryptedEmail' => $encryptedEmail,
            ]);
        } catch (\Exception $e) {
            return view('unsubscribe.result', [
                'success' => false,
                'message' => __('Invalid unsubscribe link.'),
                'email' => null,
            ]);
        }
    }

    public function processConfirmed(Request $request, string $encryptedEmail): RedirectResponse
    {
        $result = $this->subscriptionService->processUnsubscribe($encryptedEmail);

        return redirect()->route('unsubscribe.result', $encryptedEmail)
            ->with('result', $result);
    }

     public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:email_subscriptions,email',
            'country' => 'required'
        ]);

        $this->subscriptionService->subscribe($request->email);
        return response()->json([
            'success' => true,
            'message' =>
            "Thanks for signing up! We've sent you an email to confirm your address. <a href='https://www.gmail.com' target='_blank'>Check your inbox.</a>"
        ]);
    }
}
