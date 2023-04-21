<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\CompanyResource;
use App\Models\Employee;
use App\Models\User;
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
    public function store(Request $request)
    {
        dd($request);
        $request->validate([
            'account_type' => 'required',
        ]);

        if (
            $company = Company::create([
                'user_id' => Auth::user()->id,
                'company_type' => $request->account_type,
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
    public function show(Company $company)
    {
        //
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
