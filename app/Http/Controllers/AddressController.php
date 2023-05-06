<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Client;
use App\Models\Address;
use App\Models\Company;
use App\Models\Country;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\CompanyAddress;
use App\Models\EmployeeAddress;
use App\Http\Resources\ClientResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\EmployeeResources;
use App\Models\CompanyUser;
use Validator;

class AddressController extends Controller
{
    public function show($type)
    {
    }
    public function empAddress($id)
    {
        $employee = $this->employee($id);
        if ($employee) {
            return Inertia::render('Employee/Address', [
                'employee' => new EmployeeResources($employee),
                'user' => $this->employeeHeader($id),
            ]);
        }
        return redirect()->back();
    }

    public function empAddressUpdate(Request $request, $type, $id)
    {
        $request->validate([
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);
        if ($type == "employees") {

            if ($request->address_id) {
                $address = Address::where('id', $request->address_id)->update([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                ]);
            } else {
                $address = Address::create([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                ]);
                $employeeAddress = EmployeeAddress::create([
                    'employee_id' => $id,
                    'address_id' => $address->id,
                ]);
                if ($employeeAddress) {
                    return redirect(url('employees/' . $id . '/address'))->with('message', 'Employee Address Updated successfully');
                } else {
                    return redirect(url('employees/' . $id . '/address'))->with('message', 'Something went wrong on update');
                }
            }

            if ($address) {
                return redirect(url('employees/' . $id . '/address'))->with('message', 'Employee Address created successfully');
            } else {
                return redirect(url('employees/' . $id . '/address'))->with('message', 'Something went wrong on create');
            }
        }
    }
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
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }
        if ($type == 'company') {
            if (CompanyUser::where(['user_id' => $this->uid(), 'company_id' => $this->companyId()])->first()) {
                $address = CompanyAddress::where('company_id', $this->companyId())->get();
                // if ($address) {
                $address = Address::create([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                ]);
                // }
                $companyAddress = companyAddress::create([
                    'company_id' => $this->companyId(),
                    'address_id' => $address->id,
                ]);
                if ($companyAddress) {
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
        if ($type == 'employees') {

            $address = Address::create([
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'state' => $request->state,
                'country_id' => $request->country,
                'pincode' => $request->pincode,
            ]);
            // }
            $companyAddress = EmployeeAddress::create([
                'employee_id' => $request->id,
                'address_id' => $address->id,
            ]);
            if ($companyAddress) {
                return response()->json(['message' => 'Address created successfully.', 'success' => true], 200);
            }
        }
        return response()->json(['message' => 'unable to update address.', 'success' => false], 400);
    }


    // public function getcompanyAddress($id)
    // {
    //     $countries = Country::get();
    //     $company = Company::find($id);
    //     // return new CompanyResource($company);
    //     return Inertia::render('Company/Address', [
    //         'company' => new CompanyResource($company),
    //         'countries' => $countries,
    //     ]);
    // }
    public function getcompanyAddress()
    {
        $countries = Country::get();
        $company = Company::where('id', $this->companyId())->first();

        return Inertia::render('Company/Address', [
            'company' => new CompanyResource($company),
            'countries' => $countries,
        ]);
    }
    public function companyAddress(Request $request, $id)
    {
        $company = Company::where('id', $this->companyId())->first();
        // return new CompanyResource($company);
        if ($request->ajax()) {
            if ($company) {
                return response()->json([
                    'success' => true,
                    'data' => new CompanyResource($company),
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong',
            ]);
        } else {
            return $this->errorAjax();
        }
    }
    public function clientAddress(Request $request, $id)
    {
        // dd($id);
        $client = Client::where('c_id', $id)->first();
        if ($request->ajax()) {
            if ($client) {
                return response()->json([
                    'success' => true,
                    'data' => new ClientResource($client),
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong',
            ]);
        } else {
            return $this->errorAjax();
        }
    }

    public function destroy($type, $id)
    {
        if (CompanyUser::where(['user_id' => $this->uid(), 'company_id' => $this->companyId()])->first()) {
            if ($address = CompanyAddress::where(['company_id' => $this->companyId(), 'address_id' => $id])->first()) {

                if ($address->delete()) {
                    return response()->json(['success' => true, 'message' => 'Address has been deleted successfully.'], 200);
                }
            }
        }

        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
