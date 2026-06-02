<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('frontend.home');
    }

    public function loginPage(): View
    {
        return view('frontend.login');
    }

    public function registerPage(): View
    {
        return view('frontend.register');
    }
}
