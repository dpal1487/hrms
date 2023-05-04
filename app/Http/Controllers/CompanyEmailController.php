<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyEmailResource;
use Inertia\Inertia;
use App\Models\Company;
use Inertia\Controller;
use App\Models\CompanyEmail;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;

class CompanyEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $emails = CompanyEmail::where('company_id', $id)->get();
        // return new CompanyResource($company);
        return Inertia::render('Company/Email', [
            'emails' => CompanyEmailResource::collection($emails),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'email_address' => 'required',
            'is_primary' => 'required',
        ]);

        if (!empty($request->id)) {
            $emailUpdate = CompanyEmail::where('id', $request->id)->update([
                'email_address' => $request->email_address,
                'is_primary' => $request->is_primary,
            ]);
        } else {
            $emailCreate = CompanyEmail::create([
                'email_address' => $request->email_address,
                'is_primary' => $request->is_primary,
                'company_id' => $request->company_id,
            ]);

            if ($emailCreate) {
                return response()->json(['success' => true, 'message' => 'Company Email Created successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Something Went Wrong !']);
            }
        }
        if ($emailUpdate) {
            return response()->json(['success' => true, 'message' => 'Company Email Updates successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Something Went Wrong !']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyEmail  $companyEmail
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyEmail $companyEmail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyEmail  $companyEmail
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyEmail  $companyEmail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyEmail $companyEmail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyEmail  $companyEmail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $companyemail = CompanyEmail::find($id);
        if ($companyemail->delete()) {
            return response()->json(['success' => true, 'message' => 'Email has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
