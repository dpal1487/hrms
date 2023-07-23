<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard');
    }
}
