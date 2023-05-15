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
        $supplier = Supplier::where(['company_id' => $this->companyId(), 'id' => $supplier->id])->first();
        if ($supplier) {
            return Inertia::render('Supplier/Overview', [
                'supplier' => new SupplierResource($supplier)
            ]);
        }
    }
    public function supplierEdit($id)
    {
        $company = Company::get();

        $supplier = Supplier::where('company_id', $this->companyId())->find($id);
        if ($supplier) {
            return Inertia::render('Supplier/Edit', [
                'supplier' => new SupplierResource($supplier),
                'company' => $company,

            ]);
        }
    }
    public function address($id)
    {
        $supplier = Supplier::where('company_id', $this->companyId())->find($id);

        if ($supplier->address) {
            return Inertia::render('Supplier/Address', [
                'address' => new AddressResource($supplier->address),
                'supplier' => $this->supplierHeader($id),
            ]);
        }
        return Inertia::render('Supplier/Address', [
            'address' => new AddressResource($supplier),
            'supplier' => $this->supplierHeader($id),
        ]);
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
}
