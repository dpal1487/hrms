<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Http\Resources\CountryResource;
use App\Models\Address;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Alert;
use App\Http\Resources\AddressResource;
use App\Http\Resources\ContactResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectsResource;
use App\Models\ClientContact;
use App\Models\Contact;
use App\Models\Project;
use App\Models\ProjectStatus;

class ClientController extends Controller
{
    public $countries, $status;
    public function __construct($data = array())
    {
        $this->countries = CountryResource::collection(Country::orderBy('name', 'asc')->get());
        // $this->status = ProjectStatus::orderBy('id', 'asc')->get();
    }
    public function index()
    {
        $clients = new Client();
        $clients = $clients->paginate(20)->appends(request()->query());
        return Inertia::render('Client/Index', [
            'clients' => ClientResource::collection($clients),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = new Client();
        $clients = $clients->paginate(20)->appends(request()->query());
        return Inertia::render('Client/Create', [
            'countries' => $this->countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'client_name' => 'required|unique:clients,name',
            'display_name' => 'required',
            'subdomain' => 'required|unique:clients,subdomain',
            'description' => 'required',
            'address_line_1' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'primary_address' => 'required',
            'contact_country' => 'required',
            'contact_email' => 'required',
            'contact_mobile' => 'required',
            'contact_name' => 'required',
            'primary_contact' => 'required',
        ]);
        $client = Client::create(            [
                'name' => $request->client_name,
                'display_name' => $request->display_name,
                'subdomain' => $request->subdomain,
                'description' => $request->description,
                'company_id' => $this->companyId(),
                'status' => 1
            ]
        );
        if ($client) {
            $address = Address::create([
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'state' => $request->state,
                'city' => $request->city,
                'country_id' => $request->country,
                'pincode' => $request->pincode,
                'is_primary' => $request->primary_address ? 1 : 0
            ]);
            $address = ClientAddress::create([
                'client_id' => $client->id,
                'address_id' => $address->id,
            ]);
            return redirect("/client/$client->id")->with('flash', ['message' => 'Client successfully created.']);
        }
        return redirect()->back()->withErrors(['Opps something went wrong!']);
    }
    public function getClient($id)
    {
        return Client::find($id);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Inertia::render('Client/Overview', [
            'client' => new ClientResource($this->getClient($id)),
            'countries' => CountryResource::collection($this->countries)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_name' => 'required',
            'display_name' => 'required',
            'description' => 'required',
        ]);
        $client = Client::where(['id' => $id])->update(
            [
                'name' => $request->client_name,
                'display_name' => $request->display_name,
                'description' => $request->description,
            ]
        );
        if ($client) {
            return redirect("/client/$id")->with('flash', ['message' => 'Client successfully updated.']);
        }
        return redirect()->back()->withErrors(['Opps something went wrong!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function projects($id)
    {
        $projects = Project::where(['client_id' => $id])->get();
        return Inertia::render('Client/Projects', [
            'client' => new ClientResource($this->getClient($id)),
            'projects' => ProjectsResource::collection($projects),
            'status' => $this->status,
        ]);
    }

    public function address($id)
    {
        $client = Client::where('company_id', $this->companyId())->find($id);
        if ($client) {
            return Inertia::render('Client/Address', [
                'addresses' => count($client->addresses) > 0 ? AddressResource::collection($client->addresses) : [],
                'client' => new ClientResource($this->getClient($id)),
                'countries' => $this->countries
            ]);
        }
    }

    public function updateAddress(Request $request, $id)
    {
        $address = [];
        $request->validate([
            'address_line_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
            'is_primary' => 'required'
        ]);
        if (Client::where(['company_id' => $this->companyId(), 'id' => $id])->first()) {
            if ($address = ClientAddress::where(['client_id' => $id])->get()) {
                foreach ($address as $address) {
                    Address::where(['id' => $address->address_id])->update(['is_primary' => 0]);
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
            }
            if ($address) {
                return redirect("/client/$id/address")->with('flash', ['message' => 'Address successfully updated.']);
            }
            return redirect()->back()->withErrors(['Opps something went wrong!']);
        }
        return redirect()->back();
    }
    public function addAddress(Request $request, $id)
    {
        $address = [];
        $request->validate([
            'address_line_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
            'is_primary' => 'required'
        ]);
        if (Client::where(['company_id' => $this->companyId(), 'id' => $id])->first()) {
            $address = ClientAddress::where(['client_id' => $id])->get();
            foreach ($address as $address) {
                Address::where(['id' => $address->address_id])->update(['is_primary' => 0]);
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

            $address = ClientAddress::create(['client_id' => $id, 'address_id' => $address->id]);

            if ($address) {
                return redirect("/client/$id/address")->with('flash', ['message' => 'Address successfully created.']);
            }
            return redirect()->back()->withErrors(['Opps something went wrong!']);
        }
        return redirect()->back();
    }
    public function delAddress($id)
    {
        if (Address::where(['id' => $id])->delete()) {
            $address = ClientAddress::where(['address_id' => $id])->delete();
            if ($address) {
                return response()->json(['success' => true, 'message' => 'Address successfully deleted.']);
            }
            return response()->json(['success' => true, 'message' => 'Opps something went wrong!']);
        }
    }

    public function contact($id)
    {
        $client = Client::where('company_id', $this->companyId())->find($id);
        if ($client) {
            return Inertia::render('Client/Contact', [
                'contacts' => count($client->contacts) > 0 ? ContactResource::collection($client->contacts) : [],
                'client' => new ClientResource($this->getClient($id)),
                'countries' => $this->countries
            ]);
        }
    }
    public function updateContact(Request $request, $id)
    {
        $contacts = [];
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'is_primary' => 'required'
        ]);
        if (Client::where(['company_id' => $this->companyId(), 'id' => $id])->first()) {
            if ($contact = ClientContact::where(['client_id' => $id])->get()) {
                foreach ($contact as $contact) {
                    Contact::where(['id' => $contact->contact_id])->update(['is_primary' => 0]);
                }
                $contact = Contact::where(['id' => $request->id])->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'country_id' => $request->country,
                    'is_primary' => $request->is_primary ? 1 : 0,
                ]);
            }
            if ($contact) {
                return redirect("/client/$id/contact")->with('flash', ['message' => 'Contact successfully updated.']);
            }
            return redirect()->back()->withErrors(['Opps something went wrong!']);
        }
        return redirect()->back();
    }
    public function addContact(Request $request, $id)
    {
        $contacts = [];
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'is_primary' => 'required'
        ]);
        if (Client::where(['company_id' => $this->companyId(), 'id' => $id])->first()) {
            $contacts = ClientContact::where(['client_id' => $id])->get();
            foreach ($contacts as $contact) {
                Contact::where(['id' => $contact->contact_id])->update(['is_primary' => 0]);
            }
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country_id' => $request->country,
                'is_primary' => $request->is_primary ? 1 : 0,
            ]);

            $contact = ClientContact::create(['client_id' => $id, 'contact_id' => $contact->id]);

            if ($contact) {
                return redirect("/client/$id/contact")->with('flash', ['message' => 'Contact successfully created.']);
            }
            return redirect()->back()->withErrors(['Opps something went wrong!']);
        }
        return redirect()->back();
    }
    public function delContact($id)
    {
        if (Contact::where(['id' => $id])->delete()) {
            $contact = ClientContact::where(['contact_id' => $id])->delete();
            if ($contact) {
                return response()->json(['success' => true, 'message' => 'Contact successfully deleted.']);
            }
            return response()->json(['success' => true, 'message' => 'Opps something went wrong!']);
        }
    }
}
