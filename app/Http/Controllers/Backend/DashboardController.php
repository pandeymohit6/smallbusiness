<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessInquiry;
use App\Models\EmailSubscription;
use App\Models\Post;
use App\Models\User;
use App\Services\Charts\PostChartService;
use App\Services\Charts\UserChartService;
use App\Services\LanguageService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function __construct(
        private readonly UserChartService $userChartService,
        private readonly LanguageService $languageService,
        private readonly PostChartService $postChartService
    ) {
    }

    public function index()
    {
        $this->authorize('viewDashboard', User::class);
        $user = auth()->user();

        $listingQuery = Business::query();
        $inquiryQuery = BusinessInquiry::query();

        if (! $user->hasAnyRole(['Superadmin', 'Admin']) && ! $user->can('business.manage')) {
            if ($user->hasRole('Seller')) {
                $listingQuery->where('user_id', $user->id);
                $inquiryQuery->whereHas('business', fn ($query) => $query->where('user_id', $user->id));
            } elseif ($user->hasRole('Buyer')) {
                $listingQuery->active();
                $inquiryQuery->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhere('email', $user->email);
                });
            } elseif ($user->hasRole('Broker')) {
                $listingQuery->active();
                $inquiryQuery->where('broker_id', $user->id);
            } else {
                $listingQuery->whereRaw('1 = 0');
                $inquiryQuery->whereRaw('1 = 0');
            }
        }

        $dashboardData = [
            'total_users' => number_format(User::count()),
            'total_posts' => number_format(Post::count()),
            'total_roles' => number_format(Role::count()),
            'total_permissions' => number_format(Permission::count()),
            'role_counts' => [
                'buyers' => number_format(User::role('Buyer')->count()),
                'sellers' => number_format(User::role('Seller')->count()),
                'brokers' => number_format(User::role('Broker')->count()),
            ],
            'business_stats' => [
                'listings' => number_format((clone $listingQuery)->count()),
                'active_listings' => number_format((clone $listingQuery)->where('status', 'active')->count()),
                'enquiries' => number_format((clone $inquiryQuery)->count()),
                'pending_enquiries' => number_format((clone $inquiryQuery)->where('status', 'pending')->count()),
            ],
            'newsletter_stats' => [
                'total' => number_format(EmailSubscription::count()),
                'subscribed' => number_format(EmailSubscription::subscribed()->count()),
                'unsubscribed' => number_format(EmailSubscription::unsubscribed()->count()),
            ],
            'languages' => [
                'total' => number_format(count($this->languageService->getLanguages())),
                'active' => number_format(count($this->languageService->getActiveLanguages())),
            ],
            'user_growth_data' => $this->userChartService->getUserGrowthData(
                request()->get('chart_filter_period', 'last_6_months')
            )->getData(true),
            'user_history_data' => $this->userChartService->getUserHistoryData(),
            'post_stats' => $this->postChartService->getPostActivityData(
                request()->get('post_chart_filter_period', 'last_6_months')
            ),
            'breadcrumbs' => [
                'title' => __('Dashboard'),
                'show_home' => false,
                'show_current' => false,
            ],
        ];

        return view($this->dashboardViewFor($user), $dashboardData);
    }

    private function dashboardViewFor(User $user): string
    {
        if ($user->hasAnyRole(['Superadmin', 'Admin'])) {
            return 'backend.pages.dashboard.super-admin';
        }

        if ($user->hasRole('Seller')) {
            return 'backend.pages.dashboard.seller';
        }

        if ($user->hasRole('Broker')) {
            return 'backend.pages.dashboard.broker';
        }

        if ($user->hasRole('Buyer')) {
            return 'backend.pages.dashboard.buyer';
        }

        return 'backend.pages.dashboard.index';
    }
}
