<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Cashier\Cashier;
class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return Inertia::render('Dashboard');
    }
}
