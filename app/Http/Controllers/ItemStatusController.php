<?php

namespace App\Http\Controllers;

use App\Models\ItemStatus;
use App\Http\Resources\ItemStatusesResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ItemStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ItemStatuss = new ItemStatus();
        if ($request->q) {
            $ItemStatuss = $ItemStatuss->where('label', 'like', "%{$request->q}%");
        }
        $ItemStatuss = $ItemStatuss->paginate(10)->onEachSide(1)->appends(request()->query());
        $ItemStatuss = ItemStatusesResource::collection($ItemStatuss);
        return view('pages.item-status.index', compact('ItemStatuss'));
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
    public function create()
    {
        return view('pages.item-status.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required',
            'label' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
                400,
            );
        }

        $ItemStatus = ItemStatus::create([
            'text' => $request->text,
            'label' => $request->label,
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Item Status created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemStatus $itemStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemStatus $itemStatus, $id)
    {
        $ItemStatus = ItemStatus::find($id);
        $ItemStatus = new ItemStatusesResource($ItemStatus);
        return view('pages.item-status.edit', ['ItemStatus' => $ItemStatus]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemStatus $itemStatus, $id)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required',
            'text' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }
        $ItemStatus = ItemStatus::find($id);
        if ($ItemStatus) {
            $ItemStatus = ItemStatus::where(['id' => $id])->update([
                'label' => $request->label,
                'text' => $request->text,
                'description' => $request->description,
            ]);

            return response()->json(['success' => true, 'message' => 'Item Status Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemStatus $itemStatus, $id)
    {
        $ItemStatus = ItemStatus::find($id);
        $ItemStatus = new ItemStatusesResource($ItemStatus);
        if ($ItemStatus->delete()) {
            return response()->json(['success' => true, 'message' => 'Item Status has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
