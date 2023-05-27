<?php

namespace App\Http\Controllers;

use Auth;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\CompanySize;
use App\Models\CompanyEmail;
use Illuminate\Http\Request;
use App\Models\CompanyAccount;
use App\Models\CompanyAddress;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmailResource;
use App\Http\Resources\AccountResource;
use App\Http\Resources\AddressResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CorporationTypeResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\InvoiceResource;
use App\Models\Account;
use App\Models\Address;
use App\Models\CompanyUser;
use App\Models\CorporationType;
use Illuminate\Support\Facades\Validator;


class CompanyController extends Controller
{
    public $countries, $status, $address;
    public function __construct($data = array())
    {
        $this->countries = CountryResource::collection(Country::orderBy('name', 'asc')->get());
    }

    public function overviewEdit()
    {
        $company = Company::where('id', $this->companyId())->first();

        // return new CompanyResource($company);

        return Inertia::render('Company/Edit', [
            'company' => new CompanyResource($company),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'company_type' => 'required',
            'company_size_id' => 'required',
            'corporation_type_id' => 'required',
            'legal_registration_no' => 'required',
            'description' => 'required',
            'website' => 'required',
            'subdomain' => 'required',
            'linkedin_profile' => 'required',
            'skype_profile' => 'required',
        ]);
        $company = Company::where('id', $this->companyId())->first();

        if ($company) {
            $companySize = CompanySize::updateOrCreate([
                'size' => $request->company_size_id
            ]);

            $company = Company::where('id', $this->companyId())->update([
                'company_name' => $request->company_name,
                'company_type' => $request->company_type,
                'company_size_id' => $companySize->id,
                'corporation_type_id' => $request->corporation_type_id,
                'legal_registration_no' => $request->legal_registration_no,
                'description' => $request->description,
                'website' => $request->website,
                'subdomain' => $request->subdomain,
                'linkedin_profile' => $request->linkedin_profile,
                'skype_profile' => $request->skype_profile,
            ]);
            return redirect("/company")->with('flash', ['message' => 'Company successfully updated.']);
        }
        return redirect()->back()->withErrors(['Opps something went wrong!']);
    }

    public function show()
    {
        $address = CompanyAddress::where('company_id', $this->companyId())->first();
        $email = CompanyEmail::where('company_id', $this->companyId())->first();
        $company = Company::find($this->companyId());
        $corporationtypes = CorporationType::get();
        return Inertia::render('Company/Overview', [
            'company' => new CompanyResource($company),
            'address' => new AddressResource($address),
            'email' => new EmailResource($email),
            'corporationtypes' => CorporationTypeResource::collection($corporationtypes),
        ]);
    }
    public function addresses()
    {
        $company = Company::where('id', $this->companyId())->first();

        if ($company) {
            return Inertia::render('Company/Address', [
                'addresses' => count($company->addresses) > 0 ? AddressResource::collection($company->addresses) : [],
                'company' => new CompanyResource($company),
                'countries' => $this->countries
            ]);
        }
    }
    public function addAddress(Request $request)
    {
        $address = [];
        $request->validate([
            'address_line_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);
        if (CompanyUser::where(['user_id' => $this->uid(), 'company_id' => $this->companyId()])->first()) {
            $addresses = CompanyAddress::where('company_id', $this->companyId())->get();
            foreach ($addresses as $address) {
                if ($request->is_primary == true) {
                    $address = Address::where(['id' => $address->address_id])->update(['is_primary' => 0]);
                }
            }
            $address = Address::create([
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'state' => $request->state,
                'country_id' => $request->country,
                'pincode' => $request->pincode,
                'is_primary' => $request->is_primary ? 1 : 0,
            ]);
            $companyAddress = companyAddress::create([
                'company_id' => $this->companyId(),
                'address_id' => $address->id,
            ]);

            if ($companyAddress) {
                return redirect("/company/address")->with('flash', ['message' => 'Address successfully created.']);
            }
            return redirect()->back()->withErrors(['Opps something went wrong!']);
        }
        return redirect()->back();
    }
    public function updateAddress(Request $request)
    {
        $address = [];
        $request->validate([
            'address_line_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);
        if (Company::where(['id' => $this->companyId()])->first()) {
            if ($addresses = CompanyAddress::where(['company_id' => $this->companyId()])->get()) {
                foreach ($addresses as $address) {
                    if ($request->is_primary == true) {
                        $address = Address::where(['id' => $address->address_id])->update(['is_primary' => 0]);
                    }
                }
                $address = Address::where(['id' => $request->id])->update([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                    'is_primary' => $request->is_primary ? 1 : 0,
                ]);
                return redirect("/company/address")->with('flash', ['message' => 'Address successfully updated.']);
            }
            return redirect()->back()->withErrors(['Opps something went wrong!']);
        }
        return redirect()->back();
    }

    public function delAddress($id)
    {

        if (Address::where(['id' => $id])->delete()) {
            $address = CompanyAddress::where(['address_id' => $id])->delete();
            if ($address) {
                return response()->json(['success' => true, 'message' => 'Address successfully deleted.']);
            }
            return response()->json(['success' => true, 'message' => 'Opps something went wrong!']);
        }
    }


    public function accounts()
    {
        $company = Company::where('id', $this->companyId())->first();

        if ($company) {
            return Inertia::render('Company/Account', [
                'accounts' => count($company->accounts) > 0 ? AccountResource::collection($company->accounts) : [],
                'company' => new CompanyResource($company),
            ]);
        }
    }

    public function addAccount(Request $request)
    {
        $account = [];
        $request->validate([
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
        if (Company::where(['id' => $this->companyId()])->first()) {
            $account = CompanyAccount::where(['company_id' => $this->companyId()])->get();

            foreach ($account as $account) {
                if ($request->is_primary == true) {
                    Account::where(['id' => $account->account_id])->update(['is_primary' => 0]);
                }
            }
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
                'is_primary' => $request->is_primary ? 1 : 0,
            ]);

            $account = CompanyAccount::create(['company_id' => $this->companyId(), 'account_id' => $account->id]);

            if ($account) {
                return redirect("/company/accounts")->with('flash', ['message' => 'Account successfully created.']);
            }
            return redirect()->back()->withErrors(['Opps something went wrong!']);
        }
        return redirect()->back();
    }
    public function updateAccount(Request $request)
    {
        $account = [];
        $request->validate([
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
        if (Company::where(['id' => $this->companyId()])->first()) {
            if ($account = CompanyAccount::where(['Company_id' => $this->companyId()])->get()) {

                foreach ($account as $account) {
                    if ($request->is_primary == true) {
                        Account::where(['id' => $account->account_id])->update(['is_primary' => 0]);
                    }
                }
                $account = Account::where(['id' => $request->id])->update([
                    'bank_name' => $request->bank_name,
                    'bank_address' => $request->bank_address,
                    'beneficiary_name' => $request->beneficiary_name,
                    'account_number' => $request->account_number,
                    'routing_number' => $request->routing_number,
                    'swift_code' => $request->swift_code,
                    'ifsc_code' => $request->ifsc_code,
                    'sort_code' => $request->sort_code,
                    'pan_number' => $request->pan_number,
                    'is_primary' => $request->is_primary ? 1 : 0,
                ]);
            }
            if ($account) {
                return redirect("/company/accounts")->with('flash', ['message' => 'Account successfully updated.']);
            }
            return redirect()->back()->withErrors(['Opps something went wrong!']);
        }
        return redirect()->back();
    }
    public function delAccount($id)
    {
        if (Account::where(['id' => $id])->delete()) {
            $account = CompanyAccount::where(['account_id' => $id])->delete();
            if ($account) {
                return response()->json(['success' => true, 'message' => 'Account successfully deleted.']);
            }
            return response()->json(['success' => true, 'message' => 'Opps something went wrong!']);
        }
    }

    public function emails()
    {
        $company = Company::where('id', $this->companyId())->first();

        if ($company) {
            return Inertia::render('Company/Email', [
                'emails' => count($company->emails) > 0 ? EmailResource::collection($company->emails) : [],
                'company' => new CompanyResource($company),
            ]);
        }
    }

    public function addEmail(Request $request)
    {
        $email = [];
        $request->validate([
            'email_address' => 'required|unique:company_emails,email_address',
        ]);
        if (Company::where(['id' => $this->companyId()])->first()) {
            if ($email = CompanyEmail::where('company_id', $this->companyId())->get()) {
                foreach ($email as $email) {
                    if ($request->is_primary == true) {
                        CompanyEmail::where(['id' => $email->id])->update(['is_primary' => 0]);
                    }
                }
                $email =  CompanyEmail::create([
                    'email_address' => $request->email_address,
                    'is_primary' => $request->is_primary ? 1 : 0,
                    'company_id' => $this->companyId(),
                ]);
            }


            if ($email) {
                return redirect("/company/emails")->with('flash', ['message' => 'Email successfully created.']);
            }
            return redirect()->back()->withErrors(['Opps something went wrong!']);
        }
        return redirect()->back();
    }
    public function updateEmail(Request $request)
    {
        $email = [];
        $request->validate([
            'email_address' => 'required',

        ]);
        if (Company::where(['id' => $this->companyId()])->first()) {
            if ($email = CompanyEmail::where(['company_id' => $this->companyId()])->get()) {
                foreach ($email as $email) {

                    if ($request->is_primary == true) {
                        CompanyEmail::where(['id' => $email->id])->update(['is_primary' => 0]);
                    }
                }
                $email = CompanyEmail::where(['id' => $request->id])->update([
                    'email_address' => $request->email_address,
                    'is_primary' => $request->is_primary ? 1 : 0,
                    'company_id' => $this->companyId(),
                ]);
            }
            if ($email) {
                return redirect("/company/emails")->with('flash', ['message' => 'Email successfully updated.']);
            }
            return redirect()->back()->withErrors(['Opps something went wrong!']);
        }
        return redirect()->back();
    }
    public function delEmail($id)
    {
        $email = CompanyEmail::where(['id' => $id])->delete();
        if ($email) {
            return response()->json(['success' => true, 'message' => 'Email successfully deleted.']);
        }
        return response()->json(['success' => true, 'message' => 'Opps something went wrong!']);
    }

    public function invoices()
    {
        $invoices = Invoice::where('company_id', $this->companyId())->get();
        // return InvoiceResource::collection($invoices);
        return Inertia::render('Company/Invoices', [
            'invoices' => InvoiceResource::collection($invoices),
        ]);
    }


    public function projects()
    {
        $invoices = Invoice::where('company_id', $this->companyId())->get();
        // return InvoiceResource::collection($invoices);
        return Inertia::render('Company/Invoices', [
            'invoices' => InvoiceResource::collection($invoices),
        ]);
    }
    public function suppliers()
    {
        $invoices = Invoice::where('company_id', $this->companyId())->get();
        // return InvoiceResource::collection($invoices);
        return Inertia::render('Company/Invoices', [
            'invoices' => InvoiceResource::collection($invoices),
        ]);
    }
    public function destroy($id)
    {
        $company = Company::find($id);

        if ($company->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Company Deleted successfully',
            ]);
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Something went wrong !',
                ],
                400,
            );
        }
    }
}
