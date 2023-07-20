<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Http\Resources\ItemListResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ReviewResource;
use App\Models\Address;
use App\Models\Item;
use App\Models\ItemStatus;
use App\Models\User;
use App\Models\UserReview;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public $user;
    public function __construct()
    {
    }

    public $data;
    public function index(Request $request)
    {
        $users = new User();
        if ($request->q) {
            $users = $users->where('first_name', 'like', "%{$request->q}%")->orWhere('last_name', 'like', "%{$request->q}%")->orWhere('email', 'like', "%{$request->q}%")->orWhere('mobile', 'like', "%{$request->q}%");
        }
        $users = $users->paginate(10)->onEachSide(1)->appends(request()->query());

        return Inertia::render('User/Index', [
            'users' => UserResource::collection($users),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function show($id)
    {
        $data = User::find($id);
        $address = UserAddress::where('user_id', $id)->first();

        return Inertia::render('User/Overview', [
            'user' => new UserResource($data),
            'address' => $address ? new AddressResource($address) : '',
        ]);
    }

    public function address($id)
    {
        $data = User::find($id);
        $address = UserAddress::where('user_id', $id)->first();

        return Inertia::render('User/Address', [
            'user' => new UserResource($data),
            'address' => $address ? new AddressResource($address) : '',
        ]);
    }

    public function items($id)
    {
        $data = User::find($id);
        $itemStatus = ItemStatus::all();
        $items = Item::where(['user_id' => $id])->paginate(2);

        return Inertia::render('User/Items', [
            'user' => new UserResource($data),
            'itemStatus' => $itemStatus,
            'items' => ItemListResource::collection($items),
        ]);
    }

    public function updateStatus(Request $request)
    {
        $item = Item::find($request->item_id);
        $item->status_id = $request->itemstatus_id;
        $item->update();
        return response()->json(['success' => 'Status change successfully.']);
    }

    // public function statusUdate(Request $request)
    // {

    //     if (Item::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
    //         $status = $request->status == 0  ? "Inactive" : "Active";
    //                     return response()->json(['message' => StatusMessage('Brand', $status), 'success' => true]);

    //     }
    //     return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    // }



    public function packages($id)
    {
        $data = User::find($id);
        return Inertia::render('User/Packages', [
            'user' => new UserResource($data),
        ]);
        // return view('pages.user.packages', ['title' => $title, 'user' => $data]);
    }
    public function reports($id)
    {
        $title = "Item Report";
        $data = User::find($id);
        // dd($data);

        return Inertia::render('User/Reports', [
            'user' => new UserResource($data),
            'title' => $title,
        ]);
        return view('pages.user.reports', ['title' => $title, 'user' => $data]);
    }

    public function reviews($id)
    {
        $data = User::find($id);
        $reviews = UserReview::where('user_id', $id)->paginate(1);

        return Inertia::render('User/Reviews', [
            'user' => new UserResource($data),
            'review' => ReviewResource::collection($reviews),
        ]);
    }
}
