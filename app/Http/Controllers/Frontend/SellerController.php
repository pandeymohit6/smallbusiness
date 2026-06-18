<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Concerns\HandlesUserRegistration;
use App\Http\Requests\BrokerEnquiryRequest;
use App\Models\BrokerEnquiry;
use App\Models\Business;
use App\Models\User;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerController extends Controller
{
    use HandlesUserRegistration;

    public function __construct(private RegistrationService $registrationService)
    {
        $this->middleware('web');
    }
    /**
     * Show the main sell your business page
     */
    public function index(Request $request): View
    {
        $country = $request->route('country'); // null for default route

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
            return view('frontend.sellers.sell-your-business-login', compact('plans'));
        }
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
    public function registrationSelectLogin(Request $request, string $country): View|RedirectResponse
    {
        $productCode = $request->input('productCode');

        if (auth()->check() && auth()->user()->hasRole('Seller')) {
            return redirect()->route('seller.createadvert', ['country_code' => $country, 'productCode' => $productCode]);
        }
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

    public function createadvert(Request $request): View
    {
        $country = $request->input('country_code');
        $uuid = $request->input('business');
        $business = Business::where('user_id', auth()->id())->where('uuid', $uuid)->first();
        return view('frontend.sellers.createadvert', [
            'country_code' => $country,
            'business' => $business,
            'uuid' => $uuid
        ]);
    }

    /**
     * Create a new business listing (step 1 initialization)
     */
    public function createBusiness(Request $request): JsonResponse
    {
        try {

            $validated = $request->validate([
                'listing_headline' => ['required', 'string', 'max:255'],
                'general_summary' => ['required', 'string', 'min:10'],
                'business_status' => ['required', 'in:For Sale,Under Offer,Sold Subject to Contract'],
                'category' => ['required', 'string'],
                'region' => ['required', 'string'],
                'photographs' => 'nullable|array',
                'photographs.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
                'documents' => 'nullable|array',
                'documents.*' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            ]);

            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login first.'
                ], 401);
            }
            $business = Business::create([
                "uuid" => \Illuminate\Support\Str::uuid(),
                'user_id' => auth()->id(),
                'country_code' => $request->input('country_code', 'usa'),
                'title' => $validated['listing_headline'],
                'description' => $validated['general_summary'],
                'slug' => \Illuminate\Support\Str::slug($validated['listing_headline']) . '-' . uniqid(),
                'business_type' => $validated['category'],
                'industry' => $validated['category'],
                'location' => $validated['region'],
                'asking_price' => 0,
                'status' => 'draft',
                'current_step' => 1,
                'listing_headline' => $validated['listing_headline'],
                'general_summary' => $validated['general_summary'],
                'business_status' => $validated['business_status'],
                'category' => $validated['category'],
                'region' => $validated['region'],
                'photographs' => $validated['photographs'],
                'documents' => $validated['documents'],
                'draft_saved_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Business listing created successfully.',
                'business_id' => $business->id,
                'current_step' => 1
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {

            \Log::error('Create Business Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => app()->environment('production')
                    ? 'Something went wrong.'
                    : $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save form data for a specific step
     */
    public function saveStep(Request $request, Business $business): JsonResponse
    {
        if ($business->user_id !== auth()->id()) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 403);
        }

        $step = $request->input('step', 1);

        // If using FormData, fields come directly from request
        $data = $request->except([
            'step'
        ]);

        // Validation
        $rules = $this->getStepValidationRules($step);

        $request->validate(array_merge([
            'step' => 'required|in:1,2,3,4,5'
        ], $rules));

        // Save
        $business->update(array_merge($data['data'], [
            'current_step'     => $step,
            'draft_saved_at'   => now(),
        ]));

        return response()->json([
            'success' => true,
            'message' => "Step {$step} saved successfully",
            'business_id' => $business->id,
            'current_step' => $step
        ]);
    }

    /**
     * Get validation rules for each step
     */
    private function getStepValidationRules(int $step): array
    {
        return match ($step) {
            1 => [
                'data.property_status' => ['required', 'in:Free Property,Lease,Both For Sale and Leasehold,N/A'],
                'data.asking_price_range' => ['nullable', 'string'],
                'data.specific_asking_price' => ['nullable', 'numeric'],
                'data.revenue_range' => ['nullable', 'string'],
                'data.specific_revenue' => ['nullable', 'numeric'],
                'data.cash_flow_range' => ['nullable', 'string'],
                'data.specific_cash_flow' => ['nullable', 'numeric'],
            ],
            2 => [
                'data.years_established' => ['nullable', 'integer'],
                'data.management_type' => ['nullable', 'string'],
                'data.location_details' => ['nullable', 'string'],
                'data.premises_details' => ['nullable', 'string'],
            ],
            3 => [
                'data.selected_package' => ['required', 'in:6-months,3-months,1-month,test-market'],
            ],
            default => []
        };
    }

    /**
     * Get business data
     */
    public function getBusiness(Business $business): JsonResponse
    {
        if ($business->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'success' => true,
            'business' => $business,
        ]);
    }

    /**
     * Finalize business listing (publish)
     */
    public function finalizeBusiness(Request $request, Business $business): JsonResponse
    {
        if ($business->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'selected_package' => ['required', 'in:6-months,3-months,1-month,test-market'],
        ]);

        $business->update([
            'selected_package' => $validated['selected_package'],
            'status' => 'pending_review',
            'current_step' => 5,
            'published_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your listing has been submitted for review',
            'listing_id' => $business->id,
        ]);
    }

    public function countryRedirect(Request $request): RedirectResponse
    {
        $request->validate([
            'country' => 'required|exists:countries,code',
        ]);

        $country = $request->country;
        $userType = $request->user_type;
        $domain = config('app.base_domain');
        if ($userType === 'seller') {
            return redirect()->route('country.sell.business', [
                'country' => $country
            ]);
        } elseif ($userType === 'buyer') {
            return redirect()->route('country.buyer.registration', [
                'country' => $country
            ]);
        } else {
            return redirect()->route('country.broker.advertise', [
                'country' => $country
            ]);
        }
    }

    public function getbroker(): View
    {
        return view('frontend.sellers.findbroker');
    }

    public function storebrokerRequest(BrokerEnquiryRequest $request)
    {
        BrokerEnquiry::create(
            $request->validated()
        );

        return back()->with(
            'success',
            'Thank you. A broker will contact you shortly.'
        );
    }

    public function uploadFiles(Request $request): JsonResponse
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|max:10240',
            'type' => 'required|in:photo,document',
        ]);

        $directory = $request->type === 'photo'
            ? 'business/photos'
            : 'business/documents';

        $paths = [];

        foreach ($request->file('files') as $file) {
            $paths[] = $file->store($directory, 'public');
        }

        return response()->json([
            'success' => true,
            'paths' => $paths
        ]);
    }

    public function deleteFile(Request $request): JsonResponse
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = $request->input('path');

        if (\Storage::disk('public')->exists($path)) {
            \Storage::disk('public')->delete($path);
            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'File not found.'
            ], 404);
        }
    }
}
