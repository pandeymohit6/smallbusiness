<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\Hooks\AuthActionHook;
use App\Enums\Hooks\AuthFilterHook;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Support\Facades\Hook;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     */
    public function showLoginForm(): View|\Illuminate\Http\RedirectResponse
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard');
        }

        Hook::doAction(AuthActionHook::BEFORE_LOGIN_FORM_RENDER);

        //  $this->demoAppService->maybeSetDemoLocaleToEnByDefault();

        $pageTitle = Hook::applyFilters(
            AuthFilterHook::LOGIN_PAGE_TITLE,
            config('settings.auth_login_page_title') ?: __('Sign In')
        );

        $pageDescription = Hook::applyFilters(
            AuthFilterHook::LOGIN_PAGE_DESCRIPTION,
            config('settings.auth_login_page_description') ?: __('Enter your email and password to sign in!')
        );

        $showRegistrationLink = filter_var(
            config('settings.auth_enable_public_registration', '0'),
            FILTER_VALIDATE_BOOLEAN
        );

        $showForgotPassword = filter_var(
            config('settings.auth_enable_password_reset', '1'),
            FILTER_VALIDATE_BOOLEAN
        );


        $isAdminLogin = request()->is('adminlogin') || request()->routeIs('adminlogin');

        $defaultView = $isAdminLogin
            ? 'backend.auth.login'
            : 'auth.login';

        $viewName = Hook::applyFilters(
            AuthFilterHook::LOGIN_VIEW,
            $defaultView
        );
        $viewName = Hook::applyFilters(AuthFilterHook::LOGIN_VIEW, $viewName);

        return view($viewName, compact(
            'pageTitle',
            'pageDescription',
            'showRegistrationLink',
            'showForgotPassword'
        ));
    }

    /**
     * Get the post login redirect path.
     */
    protected function redirectTo(): string
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            
            // Redirect admin and superadmin users to dashboard
            // Using Spatie Permission package to check user roles
            /** @noinspection PhpUndefinedMethodInspection */
            if ($user->roles()->whereIn('name', ['superadmin', 'admin'])->exists()) {
                return RouteServiceProvider::ADMIN_DASHBOARD; // Redirect to /admin
            }

            // Redirect seller users to seller dashboard
            /** @noinspection PhpUndefinedMethodInspection */
            if ($user->hasRole('Seller')) {
                return RouteServiceProvider::SELLER_DASHBOARD;
            }

            // Redirect buyer users to buyer dashboard
            /** @noinspection PhpUndefinedMethodInspection */
            if ($user->hasRole('Buyer')) {
                return RouteServiceProvider::BUYER_DASHBOARD;
            }
        }
        
        // Default: redirect to home for non-admin users
        return RouteServiceProvider::HOME; // Redirect to /
    }

    /**
     * Validate the user login request.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $rules = Hook::applyFilters(AuthFilterHook::LOGIN_VALIDATION_RULES, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        $messages = Hook::applyFilters(AuthFilterHook::LOGIN_VALIDATION_MESSAGES, []);

        $request->validate($rules, $messages);
    }

    /**
     * Get the needed authorization credentials from the request.
     */
    protected function credentials(Request $request): array
    {
        $credentials = $request->only($this->username(), 'password');

        return Hook::applyFilters(AuthFilterHook::LOGIN_CREDENTIALS, $credentials);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        Hook::doAction(AuthActionHook::BEFORE_LOGIN_ATTEMPT, $request);

        // Try with email first
        if ($this->guard()->attempt(
            $this->credentials($request),
            $request->boolean('remember')
        )) {
            return true;
        }

        // Try with username if email failed
        $usernameCredentials = [
            'username' => $request->input($this->username()),
            'password' => $request->input('password'),
        ];

        return $this->guard()->attempt(
            $usernameCredentials,
            $request->boolean('remember')
        );
    }

    /**
     * The user has been authenticated.
     *
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //$this->demoAppService->maybeSetDemoLocaleToEnByDefault();

        Hook::doAction(AuthActionHook::AFTER_LOGIN_SUCCESS, $user, $request);

        // Allow modules to intercept the post-login response (e.g. 2FA challenge/setup).
        // Note: pass `false` as initial value — Eventy converts `null` to '' internally.
        $response = Hook::applyFilters(AuthFilterHook::AUTH_AUTHENTICATED_RESPONSE, false, $user, $request);

        if ($response) {
            return $response;
        }

        session()->flash('success', __('Successfully Logged in!'));

        return null;
    }

    /**
     * Get the failed login response instance.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        Hook::doAction(AuthActionHook::AFTER_LOGIN_FAILED, $request);

        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Hook::doAction(AuthActionHook::BEFORE_LOGOUT, $request->user());

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Hook::doAction(AuthActionHook::AFTER_LOGOUT);

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        // Use custom login route if configured and default is hidden
        $customLoginRoute = config('settings.custom_login_route');
        $hideDefaultLogin = config('settings.hide_default_login_url', '0') === '1';

        $defaultLogoutRedirect = ($customLoginRoute && $hideDefaultLogin)
            ? url($customLoginRoute)
            : route('login');

        $logoutRedirect = Hook::applyFilters(AuthFilterHook::LOGOUT_REDIRECT_PATH, $defaultLogoutRedirect);

        return $request->wantsJson()
            ? new \Illuminate\Http\JsonResponse([], 204)
            : redirect($logoutRedirect);
    }
}
