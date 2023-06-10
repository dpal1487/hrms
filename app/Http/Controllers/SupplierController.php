<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccountResource;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Country;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Resources\AddressResource;
use App\Http\Resources\SupplierResource;
use App\Models\Account;
use App\Models\Address;
use App\Models\CompanyUser;
use App\Models\SupplierAccount;
use App\Models\SupplierAddress;
use App\Models\Support;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{

    public function index(Request $request)
    {
        $suppliers = new Supplier();
        if (!empty($request->q)) {
            $suppliers = $suppliers
                ->whereHas('company', function ($query) use ($request) {
                    $query->where('company_name', 'like', "%$request->q%");
                })
                ->orWhere('supplier_name', 'like', "%$request->q%")
                ->orWhere('display_name', 'like', "%$request->q%")
                ->orWhere('website', 'like', "%$request->q%")
                ->orWhere('skype_profile', 'like', "%$request->q%")
                ->orWhere('linkedIn_profile', 'like', "%$request->q%")
                ->orWhere('description', 'like', "%$request->q%");
        }
        return Inertia::render('Supplier/Index', [
            'suppliers' => SupplierResource::collection($suppliers->paginate(10)->appends($request->all())),
        ]);
    }


    public function create()
    {
        $company = Company::get();
        return Inertia::render('Supplier/Form', ['company' => $company]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'company_id' => 'required',
            'supplier_name' => 'required',
            'display_name' => 'required',
            'website' => 'required',
            'skype_profile' => 'required',
            'linkedIn_profile' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()->first(), 'success' => false], 400);
        }

        $supplier = Supplier::create([
            'company_id' => $request->company_id,
            'supplier_name' => $request->supplier_name,
            'display_name' => $request->display_name,
            'website' => $request->website,
            'skype_profile' => $request->skype_profile,
            'linkedIn_profile' => $request->linkedIn_profile,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        if ($supplier) {
            return response()->json([
                'success' => true,
                'message' => 'Supplier Created successfully',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Supplier Not created',
        ], 400);
    }

    public function show(Supplier $supplier)
    {
        $company = Company::get();

        $supplier = Supplier::where(['company_id' => $this->companyId(), 'id' => $supplier->id])->first();
        if ($supplier->address) {
            return Inertia::render('Supplier/Overview', [
                'supplier' => new SupplierResource($supplier),
                'address' => new AddressResource($supplier->address),
                'company' => $company,

            ]);
        } else {
            if ($supplier) {
                return Inertia::render('Supplier/Overview', [
                    'supplier' => new SupplierResource($supplier),
                    'company' => $company,

                ]);
            }
        }
    }

    public function address($id)
    {
        $supplier = Supplier::where('company_id', $this->companyId())->find($id);
        $countries = Country::get();

        if ($supplier->address) {
            return Inertia::render('Supplier/Address', [
                'address' => new AddressResource($supplier->address),
                'supplier' => $this->supplierHeader($id),
                'countries' => $countries,

            ]);
        }
        return Inertia::render('Supplier/Address', [
            'address' => new AddressResource($supplier),
            'supplier' => $this->supplierHeader($id),
            'countries' => $countries,

        ]);
    }

    public function updateAddress(Request $request, $id)
    {
        $address = [];
        $validator =  Validator::make($request->all(), [
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
        }

        if (Supplier::where(['company_id' => $this->companyId()])->first()) {
            if ($address = SupplierAddress::where(['supplier_id' => $id])->first()) {
                $address = Address::where(['id' => $address->address_id])->update([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                ]);
                if ($address) {
                    return redirect("/supplier/$id/address")->with('flash', ['message' => 'Address successfully updated.']);
                }
            } else {
                $address = Address::create([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                ]);

                $empAddress = SupplierAddress::create([
                    'employee_id' => $id,
                    'address_id' => $address->id,
                ]);
                if ($empAddress) {
                    return redirect("/supplier/$id/address")->with('flash', ['message' => 'Address successfully created.']);
                }
            }
            return redirect()->back()->withErrors(['message' => 'Opps something went wrong!']);
        }
        return redirect()->back();
    }
    public function addressEdit($id)
    {
        $supplier = Supplier::where('company_id', $this->companyId())->find($id);
        $countries = Country::get();

        if ($supplier->address) {
            return Inertia::render('Supplier/SupplierAddress', [
                'address' => new AddressResource($supplier->address),
                'countries' => $countries,
                'supplier' => $this->supplierHeader($id),
            ]);
        }
        return Inertia::render('Supplier/SupplierAddress', [
            'address' => new AddressResource($supplier),
            'countries' => $countries,
            'supplier' => $this->supplierHeader($id),
        ]);
    }
    public function account($id)
    {
        $supplier = Supplier::where('company_id', $this->companyId())->find($id);
        if ($supplier->account) {
            return Inertia::render('Supplier/Account', [
                'account' => new AccountResource($supplier->account),
                'address' => $this->supplierAddress($id),

                'supplier' => $this->supplierHeader($id),

            ]);
        } else {
            return Inertia::render('Supplier/Account', [
                'account' => new AccountResource($supplier),
                'supplier' => $this->supplierHeader($id),

            ]);
        }
    }
    public function accountEdit($id)
    {
        $supplier = Supplier::where('company_id', $this->companyId())->find($id);

        // return $supplier->account;
        if ($supplier->account) {
            return Inertia::render('Supplier/SupplierAccount', [
                'account' => new AccountResource($supplier->account),
                'supplier' => $this->supplierHeader($id),
            ]);
        } else {
            return Inertia::render('Supplier/SupplierAccount', [
                'account' => new AccountResource($supplier),
                'supplier' => $this->supplierHeader($id),
            ]);
        }
    }
    public function updatAccount(Request $request, $id)
    {
        $account = [];
        $validator =  Validator::make($request->all(), [
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
            return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
        }

        if (Supplier::where(['company_id' => $this->companyId()])->first()) {
            
            if ($account = SupplierAccount::where(['supplier_id' => $id])->first()) {
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
                if ($account) {
                    return redirect("/supplier/$id/account")->with('flash', ['message' => 'Address successfully updated.']);
                }
            } else {
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

                $supAccount = SupplierAccount::create([
                    'supplier_id' => $id,
                    'account_id' => $account->id,
                ]);
                if ($supAccount) {
                    return redirect("/supplier/$id/account")->with('flash', ['message' => 'Address successfully created.']);
                }
            }
            return redirect()->back()->withErrors(['message' => 'Opps something went wrong!']);
        }
        return redirect()->back();
    }

    public function edit(Supplier $supplier)
    {
        $company = Company::get();

        return Inertia::render('Supplier/Form', [
            'supplier' => new SupplierResource($supplier),
            'company' => $company,
        ]);
    }


    public function update(Request $request, Supplier $supplier)
    {
        $validate = Validator::make($request->all(), [
            'company_id' => 'required',
            'supplier_name' => 'required',
            'display_name' => 'required',
            'website' => 'required',
            'skype_profile' => 'required',
            'linkedIn_profile' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()->first(), 'success' => false], 400);
        }

        $supplier = Supplier::where('id', $supplier->id)->update([
            'company_id' => $request->company_id,
            'supplier_name' => $request->supplier_name,
            'display_name' => $request->display_name,
            'website' => $request->website,
            'skype_profile' => $request->skype_profile,
            'linkedIn_profile' => $request->linkedIn_profile,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        if ($supplier) {
            return response()->json([
                'success' => true,
                'message' => 'Supplier updated successfully',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Supplier Not updated',
        ], 400);
    }


    public function destroy(Supplier $supplier)
    {
        if ($supplier->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Supplier Deleted Successfully'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Something Went Wrong '
        ]);
    }

    public function selectDelete(Request $request)
    {
        $supplier = Supplier::whereIn('id', $request->ids)->delete();
        if ($supplier) {
            return response()->json(['success' => true, 'message' => 'Suppliers has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
