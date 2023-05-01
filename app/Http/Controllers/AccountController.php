<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\AccountDetail;
use App\Models\CompanyAccount;
use App\Http\Resources\CompanyResource;
use Inertia\Inertia;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $company = Company::find($id);
        // return new CompanyResource($company);
        return Inertia::render('Company/Account', [
            'company' => new CompanyResource($company),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->id);
        $request->validate([
            'bank_name' => 'required',
            'bank_address' => 'required',
            'beneficiary_name' => 'required',
            'account_number' => 'required',
            'routing_number' => 'required',
            'swift_code' => 'required',
            'ifsc_code' => 'required',
            'sort_code' => 'required',
            'pan_number' => 'required',
        ]);

        if (!empty($request->id)) {
            $account = AccountDetail::where('id', $request->id)->update([
                'bank_name' => $request->bank_name,
                'bank_address' => $request->bank_address,
                'beneficiary_name' => $request->beneficiary_name,
                'account_number' => $request->account_number,
                'routing_number' => $request->routing_number,
                'swift_code' => $request->swift_code,
                'ifsc_code' => $request->ifsc_code,
                'sort_code' => $request->sort_code,
                'pan_number' => $request->pan_number,
            ]);
        } else {
            $account = AccountDetail::create([
                'bank_name' => $request->bank_name,
                'bank_address' => $request->bank_address,
                'beneficiary_name' => $request->beneficiary_name,
                'account_number' => $request->account_number,
                'routing_number' => $request->routing_number,
                'swift_code' => $request->swift_code,
                'ifsc_code' => $request->ifsc_code,
                'sort_code' => $request->sort_code,
                'pan_number' => $request->pan_number,
            ]);
            $employeeAccount = CompanyAccount::create([
                'company_id' => $request->company_id,
                'account_id' => $account->id,
            ]);
            if ($employeeAccount) {
                return response()->json(['success' => true, 'message' => 'Company Account Added successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Something Went Wrong !']);
            }
        }
        if ($account) {
            return response()->json(['success' => true, 'message' => 'Company Account Updates successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Something Went Wrong !']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = CompanyAccount::where('account_id' , '=' , $id)->first();
        // dd($account);

        if ($account->delete()) {
            return response()->json(['success' => true, 'message' => 'Account has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
