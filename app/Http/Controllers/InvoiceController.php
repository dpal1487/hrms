<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Company;
use App\Models\Client;
use App\Models\CompanyAddress;
use App\Models\InvoiceItem;
use App\Models\ConversionRate;
use App\Models\CompanyInvoice;
use App\Http\Resources\InvoiceResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AddressResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CurrencyResource;
use App\Models\ClientAddress;
use App\Models\Currency;
use Inertia\Inertia;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $company = Company::where('id', $this->companyId())->get();
        $invoices = new Invoice();
        if (!empty($request->q)) {
            $invoices = $invoices->where('invoice_number', 'like', '%' . $request->q . '%');
        }

        if (!empty($request->status) || $request->status != '') {
            $invoices = $invoices->where('status', '=', $request->status);
        }

        return Inertia::render('Invoices/Index', [
            'invoices' => InvoiceResource::collection($invoices->paginate(10)->appends($request->all())),
        ]);
    }

    public function companyAddress(Request $request, $id)
    {
        $company = CompanyAddress::where('company_id', $id)->first();

        if ($request->ajax()) {
            if ($company) {
                return response()->json([
                    'success' => true,
                    'data' => new AddressResource($company),
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
        $client = ClientAddress::where('client_id', $id)->first();
        if ($request->ajax()) {
            if ($client) {
                return response()->json([
                    'success' => true,
                    'data' => new AddressResource($client),
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
    public function create()
    {

        $companies = Company::where('id', $this->companyId())->get();
        $clients = Client::where('company_id', $this->companyId())->get();
        $currencies = Currency::get();

        return Inertia::render('Invoices/Form', [
            'companies' => CompanyResource::collection($companies),
            'clients' => $clients,
            'currencies' => CurrencyResource::collection($currencies),
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required',
            'invoice_date' => 'required',
            'conversion_rate' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'notes' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }

        $invoice = Invoice::create([
            'client_id' => $request->client,
            'company_id' => $request->company,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'conversion_rate' => $request->currency,
            'invoice_due_date' => $request->invoice_due_date,
            'total_amount_usd' => $request->total_amount_usd,
            'total_amount_inr' => $request->afterGST,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        foreach ($request->items as $value) {
            $invoiceItem = InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'project_name' => $value['name'],
                'description' => $value['description'],
                'cpi' => $value['cpi'],
                'quantity' => $value['quantity'],
            ]);
        }

        $companyInvoice = CompanyInvoice::create([
            'company_id' => $request->company,
            'invoice_id' => $invoice->id,
        ]);
        if ($companyInvoice) {
            return redirect('/invoices')->with('message', 'Invoice created successfully');
        } else {
            return redirect('/invoices')->with('message', 'Invoice not created');
        }
    }

    public function edit($id)
    {
        $invoice = Invoice::where('company_id', $this->companyId())->find($id);
        $conversionrates = ConversionRate::get();

        $companies = Company::where('id', $this->companyId())->get();
        $address = CompanyAddress::where(['company_id' => $this->companyId()])->get();
        $clients = Client::where('company_id', $this->companyId())->get();
        $currencies = Currency::get();

        return Inertia::render('Invoices/Form', [
            'companies' => $companies,
            'clients' => $clients,
            'invoice' => new InvoiceResource($invoice),
            'currencies' => CurrencyResource::collection($currencies),

        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required',
            'invoice_date' => 'required',
            'conversion_rate' => 'required',
            'invoice_due_date' => 'required',
            'notes' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }


        $invoice = Invoice::where('id', $id)->update([
            'client_id' => $request->client,
            'company_id' => $request->company,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'conversion_rate' => $request->conversion_rate,
            'invoice_due_date' => $request->invoice_due_date,
            'total_amount_usd' => $request->total_amount_usd,
            'total_amount_inr' => $request->total_amount_inr,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        foreach ($request->items as $value) {
            $invoiceItem = InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'project_name' => $value['name'],
                'description' => $value['description'],
                'cpi' => $value['cpi'],
                'quantity' => $value['quantity'],
            ]);
        }

        if ($invoice) {
            return redirect('/invoices')->with('message', 'Invoice updated successfully');
        } else {
            return redirect('/invoices')->with('message', 'Invoice not created');
        }
    }

    public function destroy($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice->delete()) {
            return response()->json(['success' => true, 'message' => 'Invoice has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
