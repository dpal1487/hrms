<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyEmailResource;
use Inertia\Inertia;
use App\Models\CompanyEmail;
use Illuminate\Http\Request;

class CompanyEmailController extends Controller
{

    public function index($id)
    {
        $emails = CompanyEmail::where('company_id', $id)->get();
        // return new CompanyResource($company);
        return Inertia::render('Company/Email', [
            'emails' => CompanyEmailResource::collection($emails),
        ]);
    }

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


    public function destroy($id)
    {
        $companyemail = CompanyEmail::find($id);
        if ($companyemail->delete()) {
            return response()->json(['success' => true, 'message' => 'Email has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
