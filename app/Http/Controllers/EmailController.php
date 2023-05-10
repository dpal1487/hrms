<?php

namespace App\Http\Controllers;

use App\Models\CompanyUser;
use App\Models\CompanyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    public function store(Request $request, $type)
    {
        $validator = Validator::make($request->all(), [
            'email_address' => 'required',
            'is_primary' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }
        if ($type == "company") {
            if (CompanyUser::where(['user_id' => $this->uid(), 'company_id' => $this->companyId()])->first()) {
                $email = CompanyEmail::where('company_id', $this->companyId());
                if ($email) {
                    CompanyEmail::create([
                        'email_address' => $request->email_address,
                        'is_primary' => $request->is_primary,
                        'company_id' => $this->companyId(),
                    ]);
                }
                return response()->json(['success' => true, 'message' => 'Company Email created successfully']);
            }
            return response()->json(['success' => false, 'message' => 'Something Went Wrong !']);
        }
    }
    public function update(Request $request, $type, $id)
    {
        $validator = Validator::make($request->all(), [
            'email_address' => 'required',
            'is_primary' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }
        if ($type == "company") {
            if (CompanyUser::where(['user_id' => $this->uid(), 'company_id' => $this->companyId()])->first()) {

                $email = CompanyEmail::where('company_id', $this->companyId());
                if ($email) {
                    CompanyEmail::where('id', $id,)->update([
                        'email_address' => $request->email_address,
                        'is_primary' => $request->is_primary,
                        'company_id' => $this->companyId(),
                    ]);
                }
                return response()->json(['success' => true, 'message' => 'Company Email Updates successfully']);
            }
            return response()->json(['success' => false, 'message' => 'Something Went Wrong !']);
        }
    }


    public function destroy($type, $id)
    {
        if ($type == "company") {
            $email = CompanyEmail::where(['id' => $id, 'company_id' => $this->companyId()])->first();
            if ($email->delete()) {
                return response()->json(['success' => true, 'message' => 'Email has been deleted successfully.']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
