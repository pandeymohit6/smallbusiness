<?php

namespace App\Http\Controllers;

use App\Models\BuyerExperience;
use App\Models\BuyerRegistration;
use App\Models\BuyerType;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    /**
     * Store buyer registration
     */
    public function store(Request $request): JsonResponse
    {
        // Validate the request
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:buyer_registrations,email'],
            'firstname' => ['required', 'string', 'min:2', 'max:255'],
            'lastname' => ['required', 'string', 'min:2', 'max:255'],
            'phone' => ['required', 'string', 'min:7'],
            'country' => ['required', 'exists:countries,id'],
            'buyer_type' => ['required', 'exists:buyer_types,id'],
            'buyer_experience' => ['required', 'exists:buyer_experiences,id'],
            'newsletter' => ['boolean'],
            'third_party_emails' => ['boolean']
        ]);

        // Create the buyer registration
        $registration = BuyerRegistration::create([
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

        return response()->json([
            'message' => 'Registration successful! You will be redirected shortly.',
            'registration_id' => $registration->id,
            'redirect_url' => route('buyer.registration.confirmation', $registration->id)
        ], 201);
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
}
