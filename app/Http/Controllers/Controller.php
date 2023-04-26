<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uid()
    {
        $user = Auth::user();
        return $user->id;
    }
    public function companyId()
    {
    }
    public function errorAjax()
    {
        return response()->json(['success' => false, 'message' => 'Unauthrize Access.']);
    }
}
