<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\InvoiceResource;


use App\Models\CompanySize;
use App\Models\Country;
use App\Models\User;
use App\Models\Invoice;
use Auth;
use Hash;
use Image;
use App\Models\Image as DBImage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies = new Company();
        if (!empty($request->q)) {
            $companies = $companies
                ->whereHas('user', function ($q) use ($request) {
                    $q->where('first_name', 'like', "%$request->q%")->orWhere('last_name', 'like', "%$request->q%");
                })
                ->orWhere('description', 'like', "%$request->q%")
                ->orWhere('company_name', 'like', "%$request->q%");
        }
        // if (!empty($request->status) || $request->status != '') {
        //     $companies = $companies->whereHas('user', function ($q) use ($request) {
        //         $q->where('active_status', '=', $request->status);
        //     });
        // }

        // return CompanyResource::collection($companies->paginate(10)->append($request->all()));
        return Inertia::render('Company/Index', [
            'companies' => CompanyResource::collection($companies->paginate(10)->append($request->all())),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Company/Form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        // dd($req);
        // $request->validate([
        //     'account_type' => 'required',
        // ]);

        $companySize = CompanySize::create([
            'size' => $req->account_team_size,
        ]);

        if (
            $company = Company::create([
                'user_id' => Auth::user()->id,
                'company_type' => $req->company_type,
                'company_size_id' => $companySize->id,
                'tax_number' => $req->tax_number,
                'account_name' => $req->account_name,
                'account_plan' => $req->account_plan,
                'company_name' => $req->company_name,
                'subdomain' => $req->company_domain,
                'website' => $req->company_website,
                'sorted_description' => $req->sorted_description,
                'description' => $req->description,
                'corporation_type_id' => $req->corporate_type,
                'contact_email' => $req->company_email,
                'contact_number' => $req->company_number,
                'card_name' => $req->card_name,
                'card_number' => $req->card_number,
                'card_expiry_month' => $req->card_expiry_month,
                'card_expiry_year' => $req->card_expiry_year,
                'card_cvv' => $req->card_cvv,
                'card_save' => $req->card_save,
            ])
        ) {
            return redirect('company')->with('message', 'Company Created Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        // return new AddressResource($company);
        return Inertia::render('Company/Overview', [
            'company' => new CompanyResource($company),
        ]);
    }

    public function accountShow($id)
    {
        // dd($id);
        $company = Company::find($id);
        // return new CompanyResource($company);
        return Inertia::render('Company/Address', [
            'company' => new CompanyResource($company),
        ]);
    }
     public function invoicesShow($id)
    {
        // dd($id);
        $company = Company::find($id);
        $invoices = Invoice::get();
        // return InvoiceResource::collection($invoices);
        // return new CompanyResource($company);
        return Inertia::render('Company/Invoices', [
            'company' => new CompanyResource($company),
            'invoices' => InvoiceResource::collection($invoices),
        ]);
    }
    public function emialsShow($id)
    {
        // dd($id);
        $company = Company::find($id);
        // return new CompanyResource($company);
        return Inertia::render('Company/Address', [
            'company' => new CompanyResource($company),
        ]);
    }

    public function projectsShow($id)
    {
        // dd($id);
        $company = Company::find($id);
        // return new CompanyResource($company);
        return Inertia::render('Company/Invoices', [
            'company' => new CompanyResource($company),
        ]);
    }
    public function suppliersShow($id)
    {
        // dd($id);
        $company = Company::find($id);
        // return new CompanyResource($company);
        return Inertia::render('Company/Invoices', [
            'company' => new CompanyResource($company),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
