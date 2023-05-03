<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Company;
use App\Models\Client;
use App\Models\CompanyAddress;
use App\Models\InvoiceItem;
use App\Models\ConversionRate;
use App\Models\CompanyInvoice;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\AddressResource;
use Inertia\Inertia;
use Auth;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // $company = Company::get();
        $company = Company::where('id', $this->companyId())->get();

        // return $company;
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
    public function create()
    {
        $companies = Company::where('id', $this->companyId())->get();
        $address = CompanyAddress::where(['company_id' => $this->companyId()])->get();
        $clients = Client::where('company_id', $this->companyId())->get();
        $conversionrates = ConversionRate::get();

        // return $clients;

        return Inertia::render('Invoices/Form', [
            'companies' => $companies,
            'clients' => $clients,
            'conversionrates' => $conversionrates,
            'address' => AddressResource::collection($address),
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'invoice_number' => 'required',
            'invoice_date' => 'required',
            'conversion_rate' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'notes' => 'required',
            'status' => 'required',
        ]);

        $invoice = Invoice::create([
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
                'price' => $value['cpi'],
                'quantity' => $value['quantity'],
            ]);
        }

        $companyInvoice = CompanyInvoice::create([
            'company_id' => Auth::user()->id,
            'invoice_id' => $invoice->id,
        ]);
        if ($companyInvoice) {
            return redirect('/invoices')->with('message', 'Invoice created successfully');
        } else {
            return redirect('/invoices')->with('message', 'Invoice not created');
        }
    }

    public function conversionValue($id)
    {
        
    }

    public function edit($id)
    {
        $invoice = Invoice::where('company_id', $this->companyId())->find($id);

        $companies = Company::where('id', $this->companyId())->get();
        $address = CompanyAddress::where(['company_id' => $this->companyId()])->get();
        $clients = Client::where('company_id', $this->companyId())->get();

        return Inertia::render('Invoices/Form', [
            'invoice' => new InvoiceResource($invoice),
            'companies' => $companies,
            'clients' => $clients,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_number' => 'required',
            'invoice_date' => 'required',
            'conversion_rate' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'invoice_due_date' => 'required',
            'notes' => 'required',
            'status' => 'required',
        ]);

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
