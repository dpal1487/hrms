<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\Country;
use App\Models\EmployeeAddress;
use App\Models\CompanyAddress;
use Illuminate\Http\Request;
use App\Http\Resources\AddressResource;
use App\Http\Resources\CompanyResource;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            // 'country' => 'required',
            'pincode' => 'required',
        ]);

        $address = Address::updateOrCreate([
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'country_id' => $request->country,
            'pincode' => $request->pincode,
        ]);

        $employeeAddress = CompanyAddress::updateOrCreate(['company_id' => $request->id], ['address_id' => $address->id]);

        if ($employeeAddress) {
            return response()->json(['success' => true, 'message' => 'Company Address Added successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'Something Went Wrong !']);
        }
    }

    public function addressShow($id)
    {
        // dd($id);
        $countries = Country::get();
        $company = Company::find($id);
        // return new AddressResource($company);
        return Inertia::render('Company/Address', [
            'company' => new CompanyResource($company),
            'countries' => $countries,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($id);
        $request->validate([
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            // 'country' => 'required',
            'pincode' => 'required',
        ]);

        $address = Address::updateOrCreate([
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'country_id' => $request->country,
            'pincode' => $request->pincode,
        ]);

        $employeeAddress = EmployeeAddress::updateOrCreate(['employee_id' => $id], ['address_id' => $address->id]);

        if ($employeeAddress) {
            return redirect(url('employees/' . $id . '/address'))->with('message', 'Employee address added successfully');
            // return response()->json(['success' => true, 'message' => 'Employee Address Added successfully']);
        } else {
            return redirect(url('employees/' . $id . '/address'))->with('message', 'Employee address not added');

            // return response()->json(['success' => true, 'message' => 'Something Went Wrong !']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }
}
