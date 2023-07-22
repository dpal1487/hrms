<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyUser;
use App\Models\Employee;
use App\Models\Supplier;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uid()
    {
        $user = Auth::user();
        return $user->id;
    }   
    public function errorAjax()
    {
        return response()->json(['success' => false, 'message' => 'Unauthrize Access.']);
    }  
  
}
