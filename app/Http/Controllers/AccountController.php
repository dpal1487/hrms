<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ClientAccount;
use App\Models\CompanyAccount;
use App\Models\Account;
use App\Models\Supplier;
use App\Models\SupplierAccount;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function store(Request $request, $type)
    {
        $validator = Validator::make($request->all(), [
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
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }

        if ($type == 'company') {
            $account = CompanyAccount::where(['company_id' => $this->companyId()])->first();
            if ($account) {
                $account = Account::create([
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
                CompanyAccount::create([
                    'company_id' => $this->companyId(),
                    'account_id' => $account->id,
                ]);
                return response()->json(['success' => true, 'message' => 'Account Added successfully']);
            }
        }
        if ($type == 'supplier') {
            $account = Supplier::where(['company_id' => $this->companyId()])->first();
            if ($account) {
                $account = Account::create([
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
                SupplierAccount::create([
                    'supplier_id' => $request->sup_id,
                    'account_id' => $account->id,
                ]);
                return response()->json(['success' => true, 'message' => 'Account Added successfully']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Something Went Wrong !']);
    }

    public function update(Request $request, $type, $id)
    {
        $validator = Validator::make($request->all(), [
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
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }
        if ($type == 'company') {
            $account = CompanyAccount::where(['account_id' => $id, 'company_id' => $this->companyId()])->first();
            if ($account) {
                Account::where(['id' => $id])->update([
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
            }
            return response()->json(['success' => true, 'message' => 'Account Updates successfully']);
        }
        if ($type == 'supplier') {
            $account = Supplier::where('company_id', $this->companyId())->first();
            if ($account) {
                Account::where(['id' => $id])->update([
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
            }
            return response()->json(['success' => true, 'message' => 'Account Updates successfully']);
        }



        if ($type == 'client') {
            $account = ClientAccount::where(['account_id' => $id, 'company_id' => $this->companyId()])->first();
            if ($account) {
                Account::where(['id' => $id])->update([]);
            }
        }
        return response()->json(['success' => false, 'message' => 'Something Went Wrong !']);
    }


    public function destroy($type, $id)
    {
        if ($type == "account") {
            $account = CompanyAccount::where(['account_id' => $id, 'company_id' => $this->companyId()])->first();
            if ($account->delete()) {
                return response()->json(['success' => true, 'message' => 'Account has been deleted successfully.']);
            }
        }
        if ($type == "client") {
            $account = ClientAccount::where(['account_id' => $id, 'company_id' => $this->companyId()])->first();
            if ($account->delete()) {
                return response()->json(['success' => true, 'message' => 'Account has been deleted successfully.']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
