<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
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

    public function getPages(string $slug): View
    {
        $pages = Post::where('slug', $slug)->firstOrFail();
        return view('frontend.pages', compact('pages'));
    }
}
