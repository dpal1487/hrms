<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\ItemStatus;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemStatusesResource;
use Inertia\Inertia;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

        $items = new Item();
        if ($request->q) {
            $items = $items->where('name', 'like', "%{$request->q}%");
        } elseif ($request->status != null) {
            $items = $items->where('status_id', '=', intval($request->status));
        }
        $items = $items
            ->paginate(2)
            ->onEachSide(1)
            ->appends(request()->query());
        $itemStatus = ItemStatus::all();
        return Inertia::render('Item/Index', [
            'items' => ItemResource::collection($items),
            'itemStatus' => ItemStatusesResource::collection($itemStatus)
        ]);
    }
    // public function statusUdate(Request $request)
    // {

    //     if (Attribute::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
    //         $status = $request->status == 0  ? "Inactive" : "Active";
    //                     return response()->json(['message' => StatusMessage('Brand', $status), 'success' => true]);

    //     }
    //     return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    // }

    public function updateStatus(Request $request)
    {
        $item = Item::find($request->id);
        $item->status_id = $request->status;
        $item->update();
        return response()->json([
            'message' => 'status updated successfully',
            'success' => true
        ]);
    }

    public function items($id)
    {
        $title = "Item Details";
        $data = User::find($id);

        $itemStatus = ItemStatus::all();

        $item = Item::where(['user_id' => $id])->get();

        return view('pages.users.items', ['title' => $title, 'user' => $data, 'itemstatus' => $itemStatus, 'items' => ItemResource::collection($item)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function details($id)
    {
        $title = "Item Details";
        $item = Item::where(['id' => $id])->get();

        return view('pages.item.details', ['title' => $title, 'itemdetails' => ItemResource::collection($item)]);
    }
}
