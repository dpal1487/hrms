<?php

namespace App\Http\Controllers;

use App\Models\Enquirie;
use Illuminate\Http\Request;

class EnquirieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $enquiries = new Enquirie();
        if($request->q){
            $enquiries = $enquiries->where('name','like',"%{$request->q}%");
        }
        $enquiries = $enquiries->paginate(10)->onEachSide(1)->appends(request()->query());
        // $data = User::latest()->paginate(10);
        return view('pages.enquiries.index' , ['result' =>$enquiries]);
    }
    // public function statusUdate(Request $request)
    // {

    //     if (Attribute::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
    //         $status = $request->status == 0  ? "Inactive" : "Active";
    //         return response()->json(['message' => "Your Status has been " . $status, 'success' => true]);
    //     }
    //     return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function status(Request $request)
    {
        $enquire = Enquirie::find($request->enquire_id);

        // dd($request->enquirestatus_id);
        if ($request->enquirestatus_id == 0) {
            $enquire->status = 1;
        } else {
            $enquire->status = 0;
        }
            $enquire->update();
            return response()->json(['success'=>'Status change successfully.']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Enquirie $enquirie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enquirie $enquirie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enquirie $enquirie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enquirie $enquirie)
    {
        //
    }
}
