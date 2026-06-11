<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Concerns\HandlesUserRegistration;
use App\Models\User;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerController extends Controller
{
    use HandlesUserRegistration;

    public function __construct(private RegistrationService $registrationService)
    {
    }
    /**
     * Show the main sell your business page
     */
    public function index(): View
    {
        return view('frontend.sellers.sell-your-business');
    }

    /**
     * Show the sell your business form for a specific country
     */
    public function create(string $code): View
    {
        return view('frontend.sellers.sell-your-business-login');
    }

    /**
     * Show the seller registration login selection page
     */
    public function registrationSelectLogin(string $code): View
    {
        return view('frontend.sellers.registration-select-login');
    }

    /**
     * Show the seller registration details page
     */
    public function registrationDetails(string $code): View
    {
        $countriesData = \App\Models\Country::active()->get(['id', 'name', 'phone_code', 'code']);
        return view('frontend.sellers.registration-details', [
            'countriesData' => $countriesData
        ]);
    }

    /**
     * Store seller registration
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'firstname' => ['required', 'string', 'min:2', 'max:255'],
            'lastname' => ['required', 'string', 'min:2', 'max:255'],
            'phone' => ['required', 'string', 'min:7'],
            'country' => ['required', 'exists:countries,id'],
            'newsletter' => ['boolean'],
        ]);

        // Register or get existing user
        $user = $this->registrationService->registerUserWithRole([
            'email' => $validated['email'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'password' => $request->password,
        ], 'Seller');

        return response()->json([
            'message' => 'Registration successful! You will be redirected shortly.',
            'redirect_url' => route('seller.registration.confirmation', [
                'user' => $user->id
            ])
        ], 201);
    }

    /**
     * Show registration confirmation
     */
    public function confirmation(User $user): View
    {
        return view('frontend.sellers.registration_confirmation', [
            'user' => $user
        ]);
    }
}
