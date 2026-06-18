<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Concerns\HandlesUserRegistration;
use App\Models\BuyerExperience;
use App\Models\BusinessBuyer;
use App\Models\BuyerType;
use App\Models\Country;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BuyerController extends Controller
{
    use HandlesUserRegistration;

    public function __construct(private RegistrationService $registrationService)
    {
        $this->middleware('web');
    }

    /**
     * Show the main sell your business page
     */
    public function index(Request $request): View|RedirectResponse
    {
        $country = $request->route('country');
        if ($country) {
            $plans = [
                [
                    'code' => 'ADS_6M',
                    'duration' => '6 Months',
                    'price' => 399,
                    'badge' => 'Best Value',
                    'featured' => true,
                    'features_title' => 'Advertise your business for 180 days',
                    'features' => [
                        '<strong>No</strong> credit card details required',
                        'See buyer interest <strong>before</strong> you pay*',
                    ],
                    'note' => '*Buyer contact details <strong>will not</strong> be provided until you pay to advertise.',
                    'button' => 'Buy Now',
                ],
                [
                    'code' => 'ADS_3M',
                    'duration' => '3 Months',
                    'price' => 299,
                    'badge' => null,
                    'featured' => false,
                    'features_title' => 'Advertise your business for 90 days',
                    'features' => [
                        '<strong>No</strong> credit card details required',
                        'See buyer interest <strong>before</strong> you pay*',
                    ],
                    'note' => '*Buyer contact details will not be provided until you pay to advertise.',
                    'button' => 'Buy Now',
                ],
                [
                    'code' => 'ADS_1M',
                    'duration' => '1 Month',
                    'price' => 199,
                    'badge' => null,
                    'featured' => false,
                    'features_title' => 'Advertise your business for 30 days',
                    'features' => [
                        '<strong>No</strong> credit card details required',
                        'See buyer interest <strong>before</strong> you pay*',
                    ],
                    'note' => '*Buyer contact details will not be provided until you pay to advertise.',
                    'button' => 'Buy Now',
                ],
                [
                    'code' => 'ADS_TRIAL',
                    'duration' => 'Test The Market',
                    'price' => 0,
                    'badge' => null,
                    'featured' => false,
                    'features_title' => 'Advertise your business for 20 days',
                    'features' => [
                        '<strong>No</strong> credit card details required',
                        'See buyer interest <strong>before</strong> you pay*',
                    ],
                    'note' => '*Buyer contact details <strong>will not</strong> be provided until you pay to advertise.',
                    'button' => 'Start Now',
                ],
            ];
            return view('frontend.buyers.registrationform', compact('plans'));
        }

        return view('frontend.buyers.registration');
    }

    /**
     * Show the sell your business form for a specific country
     */
    public function create(string $code): View
    {
        return view('frontend.buyers.registration-select-login');
    }

    /**
     * Show buyer registration details form
     */
    public function details(string $code): View
    {
        $countriesData = Country::active()->get(['id', 'name', 'phone_code', 'code']);
        $buyerTypes = BuyerType::active()->orderBy('sort_order')->get(['id', 'name']);
        $buyerExperiences = BuyerExperience::active()->orderBy('sort_order')->get(['id', 'name']);

        return view('frontend.buyers.registrationformdetails', [
            'countriesData' => $countriesData,
            'buyerTypes' => $buyerTypes,
            'buyerExperiences' => $buyerExperiences
        ]);
    }

    /**
     * Show the buyer registration login selection page
     */
    public function registrationSelectLogin(string $code): View
    {
        return view('frontend.buyers.registration-select-login');
    }

    /**
     * Store buyer registration
     */
    public function store(Request $request): JsonResponse
    {
        // Validate the request
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'firstname' => ['required', 'string', 'min:2', 'max:255'],
            'lastname' => ['required', 'string', 'min:2', 'max:255'],
            'phone' => ['required', 'string', 'min:7'],
            'country' => ['required', 'exists:countries,id'],
            'buyer_type' => ['required', 'exists:buyer_types,id'],
            'buyer_experience' => ['required', 'exists:buyer_experiences,id'],
            'newsletter' => ['boolean'],
            'third_party_emails' => ['boolean']
        ]);

        // Register or get existing user
        $user = $this->registrationService->registerUserWithRole([
            'email' => $validated['email'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'password' => $request['password'],
        ], 'Buyer');

        // Create the buyer registration
        $registration = BusinessBuyer::create([
            'user_id' => $user->id,
            'first_name' => $validated['firstname'],
            'last_name' => $validated['lastname'],
            'phone' => $validated['phone'],
            'country_id' => $validated['country'],
            'buyer_type_id' => $validated['buyer_type'],
            'buyer_experience_id' => $validated['buyer_experience'],
            'newsletter' => $validated['newsletter'] ?? false,
            'third_party_emails' => $validated['third_party_emails'] ?? false,
            'status' => 'pending'
        ]);
        return response()->json([
            'message' => 'Registration successful! You will be redirected shortly.',
            'registration_id' => $registration->id,
            'redirect_url' => route('buyer.registration.confirmation', $registration->id)
        ], 201);
    }

    /**
     * Show registration confirmation
     */
    public function confirmation(BusinessBuyer $businessBuyer): View
    {
        return view('frontend.buyers.registration_confirmation', [
            'registration' => $businessBuyer
        ]);
    }

    /**
     * Show the buy a business search page
     */
    public function buyABusiness(): View
    {
        return view('frontend.buyers.buy_business');
    }

    public function maVault(): View
    {
        return view('frontend.buyers.ma_vault');
    }
}
