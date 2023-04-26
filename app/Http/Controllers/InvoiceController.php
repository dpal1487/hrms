<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Company;
use App\Models\Client;
use App\Models\CompanyInvoice;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\ClientResource;
use Inertia\Inertia;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // dd($id);
        $company = Company::get();
        $invoices = Invoice::get();
        // return InvoiceResource::collection($invoices);
        // return new CompanyResource($company);
        return Inertia::render('Invoices/Index', [
            // 'company' => new CompanyResource($company),
            'invoices' => InvoiceResource::collection($invoices),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::get();
        $clients = Client::get();
        // var_dump($clients);
        return Inertia::render('Invoices/Form', [
            'companies' => $companies,
            'clients' => ClientResource::collection($clients),
        ]);
    }

 public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'company' => 'required',
            'gst_status' => 'required',
            'gst_status' => 'required',
            'invoice_number' => 'required',
            'invoice_date' => 'required',
            'conversion_rate' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'invoice_due_date' => 'required',
            'total_amount_usd' => 'required',
            'total_amount_inr' => 'required|integer',
            'notes' => 'required',
            'status' => 'required',
        ]);

        $invoice = Invoice::create([
            'client' => $request->client,
            'company_id' => $request->company,
            'gst_status' => $request->gst_status,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'conversion_rate' => $request->conversion_rate,
            'invoice_due_date' => $request->invoice_due_date,
            'total_amount_usd' => $request->total_amount_usd,
            'total_amount_inr' => $request->total_amount_inr,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $companies = Company::get();
        $clients = Client::get();

        // return new InvoiceResource($invoice);

        return Inertia::render('Invoices/Form', [
            'invoice' => new InvoiceResource($invoice),
            'companies' => $companies,
            'clients' => $clients,
        ]);

        // return $invoice;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'company' => 'required',
            'gst_status' => 'required',
            'gst_status' => 'required',
            'invoice_number' => 'required',
            'invoice_date' => 'required',
            'conversion_rate' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'invoice_due_date' => 'required',
            'total_amount_usd' => 'required',
            'total_amount_inr' => 'required|integer',
            'notes' => 'required',
            'status' => 'required',
        ]);

        $invoice = Invoice::where('id', $id)->update([
            'client_id' => $request->client,
            'company_id' => $request->company,
            'gst_status' => $request->gst_status,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'conversion_rate' => $request->conversion_rate,
            'invoice_due_date' => $request->invoice_due_date,
            'total_amount_usd' => $request->total_amount_usd,
            'total_amount_inr' => $request->total_amount_inr,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        // $companyInvoice = CompanyInvoice::create([
        //     'company_id' => $request->company,
        //     'invoice_id' => $invoice->id,
        // ]);
        if ($invoice) {
            return redirect('/invoices')->with('message', 'Invoice updated successfully');
        } else {
            return redirect('/invoices')->with('message', 'Invoice not created');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        if ($invoice->delete()) {
            return response()->json(['success' => true, 'message' => 'Invoice has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
