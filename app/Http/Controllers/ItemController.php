<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\ItemStatus;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemReviewsResource;
use App\Http\Resources\ItemStatusesResource;
use App\Http\Resources\UserResource;
use Inertia\Inertia;

class ItemController extends Controller
{
    public $itemstatus;

    public function __construct()
    {
        $this->itemstatus = ItemStatusesResource::collection(ItemStatus::all());
    }
    public function index(Request $request)
    {
        $items = new Item();
        if ($request->q) {
            $items = $items->where('name', 'like', "%{$request->q}%");
        }
        if (!empty($request->s) || $request->s != null) {
            $items = $items->where('status_id', '=', $request->s);
        }
        return Inertia::render('Item/Index', [
            'items' => ItemResource::collection($items->paginate(2)->onEachSide(1)->appends(request()->query())),
            'itemStatus' => $this->itemstatus,
        ]);
    }
    public function statusUdate(Request $request)
    {
        $item = Item::find($request->id);
        $item->status_id = $request->status;
        $item->update();
        return response()->json([
            'message' => 'status updated successfully',
            'success' => true
        ]);
    }

    public function show($id)
    {
        $item = Item::where(['user_id' => $id])->get();
        return Inertia::render('Item/Show', [
            'itemdetails' => new ItemResource(Item::find($id)),
            'user' => new UserResource(User::find($id)),
            'itemStatus' => $this->itemstatus,
        ]);
    }


    public function reviews($id)
    {
        return Inertia::render('Item/Review', [
            'itemreview' => new ItemReviewsResource(Item::find($id))
        ]);
    }
}
