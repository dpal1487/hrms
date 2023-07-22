<?php

namespace App\Http\Controllers;

use App\Http\Resources\EnquiryResource;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $enquiries = new Enquiry();
        if ($request->q) {
            $enquiries = $enquiries->where('name', 'like', "%{$request->q}%");
        }

        // $data = User::latest()->paginate(10);
        return Inertia::render('Enquires/Index', [
            'enquiries' => EnquiryResource::collection($enquiries->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }

    public function statusUdate(Request $request)
    {

        if (Enquiry::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Enquiry', $status), 'success' => true]);

        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }
}
