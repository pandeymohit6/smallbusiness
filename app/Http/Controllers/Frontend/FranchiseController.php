<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FranchiseController extends Controller
{
    /**
     * Show franchises for sale
     */
    public function index(): View
    {
        return view('frontend.franchise.resales-for-sale');
    }

    /**
     * Show franchise details
     */
    public function show(string $slug): View
    {
        return view('frontend.franchise.show', ['slug' => $slug]);
    }

    public function franchiseList(): View
    {
        return view('frontend.franchise.list');
    }

    public function advertise(): View
    {
        return view('frontend.franchise.advertise');
    }
}
