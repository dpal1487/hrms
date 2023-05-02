<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyUser;

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
        $company = CompanyUser::where(['user_id' => $this->uid()])->first();
        return $company->company_id;
    }
    public function errorAjax()
    {
        return response()->json(['success' => false, 'message' => 'Unauthrize Access.']);
    }
}
