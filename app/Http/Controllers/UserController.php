<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\ItemListResource;
use App\Http\Resources\UserPackagesResource;
use App\Http\Resources\UserReportsResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserReviewsResource;
use App\Models\Address;
use App\Models\Country;
use App\Models\Item;
use App\Models\ItemStatus;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserReview;
use App\Models\UserAddress;
use App\Models\UserReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Predis\Protocol\Text\Handler\ErrorResponse;

class UserController extends Controller
{
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
            'countries' => CountryResource::collection(Country::get()),
        ]);
    }

    public function items($id)
    {
        $data = User::find($id);
        $itemStatus = ItemStatus::all();
        $address = UserAddress::where('user_id', $id)->first();

        $items = Item::where(['user_id' => $id])->paginate(2);

        return Inertia::render('User/Items', [
            'user' => new UserResource($data),
            'itemStatus' => $itemStatus,
            'items' => ItemListResource::collection($items),
            'address' => $address ? new AddressResource($address) : '',

        ]);
    }
    public function updateStatus(Request $request)
    {
        $item = Item::find($request->item_id);
        $item->status_id = $request->itemstatus_id;
        $item->update();
        return response()->json(['success' => 'Status change successfully.']);
    }
    public function reviews($id)
    {
        $data = User::find($id);
        $reviews = UserReview::where('user_id', $id)->paginate(5);
        $address = UserAddress::where('user_id', $id)->first();
        return Inertia::render('User/Reviews', [
            'user' => new UserResource($data),
            'reviews' => UserReviewsResource::collection($reviews),
            'address' => $address ? new AddressResource($address) : '',
        ]);
    }



    public function packages($id)
    {
        $data = User::find($id);
        $address = UserAddress::where('user_id', $id)->first();
        $packages = Subscription::where('user_id', $id)->get();

        return Inertia::render('User/Packages', [
            'user' => new UserResource($data),
            'address' => $address ? new AddressResource($address) : '',
            'packages' => UserPackagesResource::collection($packages),

        ]);
    }
    public function reports($id)
    {
        $user = User::find($id);
        $address = UserAddress::where('user_id', $id)->first();
        $reports = UserReports::where('user_id', $id)->get();

        return Inertia::render('User/Reports', [
            'user' => new UserResource($user),
            'address' => $address ? new AddressResource($address) : '',
            'reports' => UserReportsResource::collection($reports),
        ]);
    }
}
