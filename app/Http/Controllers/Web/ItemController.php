<?php

namespace App\Http\Controllers\Web;

use App\Http\Resources\Web\Item\ItemCustomerResource;
use App\Http\Resources\Web\Item\ItemListResource;
use App\Http\Resources\Web\Item\ItemOverViweResource;
use App\Models\Item;
use App\Models\User;
use App\Models\ItemStatus;
use Illuminate\Http\Request;
use App\Http\Resources\Web\Item\ItemReviewsResource;
use App\Http\Resources\Web\Item\ItemStatusesResource;
use App\Http\Resources\Web\UserResource;
use App\Models\File;
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
            'items' => ItemListResource::collection($items->paginate(2)->onEachSide(1)->appends(request()->query())),
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
        return Inertia::render('Item/Show', [
            'itemdetails' => new ItemOverViweResource(Item::find($id)),
            'user' => new UserResource(User::find($id)),
            'itemStatus' => $this->itemstatus,
        ]);
    }


    public function reviews($id)
    {
        $item = Item::find($id);
        if (!empty($item)) {
            $averageRating = $item->reviews->average(function ($itemReview) {
                return $itemReview->review->rating;
            });
        }
        return Inertia::render('Item/Review', [
            'itemreview' => new ItemReviewsResource(Item::find($id)),
            'average_rating' => $averageRating ?  number_format("$averageRating", 1) : null
        ]);
    }
    public function customers($id)
    {
        return Inertia::render('Item/Customers', [
            'customerreview' => new ItemCustomerResource(Item::find($id))
        ]);
    }
    public function documentDownload($id)
    {
        $document = File::find($id);
        return response()->download($document->file_path);
    }
}
