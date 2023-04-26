<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\Country;
use App\Models\Client;
use App\Models\EmployeeAddress;
use App\Models\CompanyAddress;
use Illuminate\Http\Request;
use App\Http\Resources\AddressResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\ClientResource;


use Inertia\Inertia;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->id);
        $request->validate([
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            // 'country' => 'required',
            'pincode' => 'required',
        ]);

        if (!empty($request->id)) {
            $address = Address::where('id', $request->id)->update([
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
            $employeeAddress = CompanyAddress::create([
                'company_id' => $request->company_id,
                'address_id' => $address->id,
            ]);
            if ($employeeAddress) {
                return response()->json(['success' => true, 'message' => 'Company Address Added successfully']);
            } else {
                return response()->json(['success' => true, 'message' => 'Something Went Wrong !']);
            }
        }
        if ($address) {
            return response()->json(['success' => true, 'message' => 'Company Address Updates successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'Something Went Wrong !']);
        }
    }

    public function addressShow($id)
    {
        $countries = Country::get();
        $company = Company::find($id);
        // return new CompanyResource($company);
        return Inertia::render('Company/Address', [
            'company' => new CompanyResource($company),
            'countries' => $countries,
        ]);
    }
    public function clientAddress(Request $request , $id)
    {
        // dd($id);
        $client = Client::where('c_id', $id)->first();

        // return $client;
        // return new ClientResource($client);

        if ($request->ajax()) {
            if ($client) {
                return response()->json([
                    'success' => true,
                    'data' =>new ClientResource($client),
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

    public function destroy($id)
    {
        $address = CompanyAddress::where('address_id', '=', $id)->first();
        if ($address->delete()) {
            return response()->json(['success' => true, 'message' => 'Address has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
