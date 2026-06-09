<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BusinessBuyer;
use App\Models\BuyerExperience;
use App\Models\BuyerRegistration;
use App\Models\BuyerType;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class BuyerRegistrationController extends Controller
{
    /**
     * Show the buyer registration form
     */
    public function create(): View
    {
        $countries = Country::active()->get(['id', 'name', 'phone_code']);
        $buyerTypes = BuyerType::active()->orderBy('sort_order')->get(['id', 'name']);
        $buyerExperiences = BuyerExperience::active()->orderBy('sort_order')->get(['id', 'name']);

        return view('frontend.buyers.registrationformdetails', [
            'countries' => $countries,
            'buyerTypes' => $buyerTypes,
            'buyerExperiences' => $buyerExperiences
        ]);
    }

    /**
     * Get all registration options as JSON
     */
    public function getOptions(): JsonResponse
    {
        return response()->json([
            'countries' => Country::active()->get(['id', 'name', 'phone_code']),
            'buyer_types' => BuyerType::active()->orderBy('sort_order')->get(['id', 'name']),
            'buyer_experiences' => BuyerExperience::active()->orderBy('sort_order')->get(['id', 'name'])
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email|unique:buyer_registrations,email',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'firstname' => 'required|string|min:2',
            'lastname' => 'required|string|min:2',
            'phone' => 'required|string|min:7',
            'country' => 'required|exists:countries,id',
            'buyer_type' => 'required|exists:buyer_types,id',
            'buyer_experience' => 'required|exists:buyer_experiences,id',
            'newsletter' => 'boolean',
            'third_party_emails' => 'boolean'
        ]);

        try {
            DB::transaction(function () use ($validated, $request) {

                $user = User::create([
                    'country_code' => $validated['country'],
                    'first_name' => $validated['firstname'],
                    'last_name' => $validated['lastname'],
                    'email' => $validated['email'],
                    'username' => $this->generateUniqueUsername($validated['email']),
                    'password' => Hash::make($validated['password']),
                ]);

                BusinessBuyer::create([
                    'user_id' => $user->id,
                    'first_name' => $validated['firstname'],
                    'last_name' => $validated['lastname'],
                    'phone_code' => $request->phone_code ?? '+1',
                    'phone' => $validated['phone'],
                    'country' => $validated['country'],
                    'buyer_type' => $validated['buyer_type'],
                    'buyer_experience' => $validated['buyer_experience'],
                    'newsletter' => $validated['newsletter'] ?? false,
                    'third_party_email' => $validated['third_party_emails'] ?? false,
                ]);

                // Also store in buyer_registrations table
                BuyerRegistration::create([
                    'email' => $validated['email'],
                    'firstname' => $validated['firstname'],
                    'lastname' => $validated['lastname'],
                    'phone' => $validated['phone'],
                    'country_id' => $validated['country'],
                    'buyer_type_id' => $validated['buyer_type'],
                    'buyer_experience_id' => $validated['buyer_experience'],
                    'newsletter' => $validated['newsletter'] ?? false,
                    'third_party_emails' => $validated['third_party_emails'] ?? false,
                    'status' => 'pending'
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! You will be redirected shortly.',
                'redirect_url' => route('buyer.registration.confirmation')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during registration. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show registration confirmation
     */
    public function confirmation(BuyerRegistration $buyerRegistration): View
    {
        return view('frontend.buyers.registration-confirmation', [
            'registration' => $buyerRegistration
        ]);
    }

      /**
     * Generate a unique username from email.
     */
    protected function generateUniqueUsername(string $email): string
    {
        // Get the part before @ from email
        $baseUsername = strtolower(explode('@', $email)[0]);

        // Remove any special characters, keep only alphanumeric and underscores
        $baseUsername = preg_replace('/[^a-z0-9_]/', '', $baseUsername);

        // Ensure it's not empty
        if (empty($baseUsername)) {
            $baseUsername = 'user';
        }

        // Check if username exists, if so append a number
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername.$counter;
            $counter++;
        }

        return $username;
    }
}
