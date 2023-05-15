<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\CompanyAddress;
use App\Models\EmployeeAddress;
use App\Models\CompanyUser;
use App\Models\Supplier;
use App\Models\SupplierAddress;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function store(Request $request, $type)
    {
        $validator = Validator::make($request->all(), [
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'success' => false], 400);
        }
        if ($type == 'company') {

            if (CompanyUser::where(['user_id' => $this->uid(), 'company_id' => $this->companyId()])->first()) {
                $address = CompanyAddress::where('company_id', $this->companyId())->get();
                $address = Address::create([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                ]);
                $companyAddress = companyAddress::create([
                    'company_id' => $this->companyId(),
                    'address_id' => $address->id,
                ]);
                if ($companyAddress) {
                    return response()->json(['message' => 'Address created successfully.', 'success' => true], 200);
                }
            }
        }
        if ($type == 'employees') {

            if (CompanyUser::where(['user_id' => $this->uid(), 'company_id' => $this->companyId()])->first()) {
                $address = Address::create([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                ]);
                $employeeAddress = EmployeeAddress::create([
                    'employee_id' => $request->emp_id,
                    'address_id' => $address->id,
                ]);
                if ($employeeAddress) {
                    return response()->json(['message' => 'Address created successfully.', 'success' => true], 200);
                }
            }
        }
        if ($type == 'supplier') {
            if (Supplier::where('company_id', $this->companyId())->first()) {
                $address = Address::create([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                ]);
                $supplierAddress = SupplierAddress::create([
                    'supplier_id' => $request->sup_id,
                    'address_id' => $address->id,
                ]);
                if ($supplierAddress) {
                    return response()->json(['message' => 'Address created successfully.', 'success' => true], 200);
                }
            }
        }

        return response()->json(['message' => 'Unable to craete address.', 'success' => false], 400);
    }
    public function update(Request $request, $type, $id)
    {

        $validator = Validator::make($request->all(), [
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }
        if ($type == 'company') {
            if (CompanyUser::where(['user_id' => $this->uid(), 'company_id' => $this->companyId()])->first()) {
                if (CompanyAddress::where(['company_id' => $this->companyId(), 'address_id' => $id])->first()) {
                    $address = Address::where('id', $id)->update([
                        'address_line_1' => $request->address_line_1,
                        'address_line_2' => $request->address_line_2,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country_id' => $request->country,
                        'pincode' => $request->pincode,
                    ]);
                    if ($address) {
                        return response()->json(['message' => 'Address updated successfully.', 'success' => true], 200);
                    }
                }
            }
        }
        if ($type == 'employee') {
            if (CompanyUser::where(['user_id' => $this->uid(), 'company_id' => $this->companyId()])->first()) {

                $address = Address::where('id', $id)->update([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                ]);
                if ($address) {
                    return response()->json(['message' => 'Address updated successfully.', 'success' => true], 200);
                }
            }
        }
        if ($type == 'supplier') {
            if (CompanyUser::where(['user_id' => $this->uid(), 'company_id' => $this->companyId()])->first()) {

                $address = Address::where('id', $id)->update([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                ]);
                if ($address) {
                    return response()->json(['message' => 'Address updated successfully.', 'success' => true], 200);
                }
            }
        }
        return response()->json(['message' => 'unable to update address.', 'success' => false], 400);
    }
    public function destroy($type, $id)
    {
        if ($type == "company") {
            if (CompanyUser::where(['user_id' => $this->uid(), 'company_id' => $this->companyId()])->first()) {
                if ($address = CompanyAddress::where(['company_id' => $this->companyId(), 'address_id' => $id])->first()) {

                    if ($address->delete()) {
                        return response()->json(['success' => true, 'message' => 'Address has been deleted successfully.'], 200);
                    }
                }
            }
        }

        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
