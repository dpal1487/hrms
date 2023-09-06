<?php

namespace App\Http\Controllers\Api;

use App\Events\PostAdsEvent;
use App\Http\Controllers\Api\Controller;

use Illuminate\Http\Request;
use App\Http\Resources\Api\AddressResource;
use App\Http\Resources\Api\AttributesResource;
use App\Http\Resources\Api\TimeResource;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Address;
use App\Models\TimePeriod;
use App\Models\Item;
use App\Models\ItemAttribute;
use App\Models\UserAddress;
use App\Models\ItemLocation;
use App\Notifications\NewPostNotification;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
  public function index(Request $request)
  {
    $category = Category::find($request->category_id);
    $address = UserAddress::where(['user_id' => $this->uid()])->first();
    return [
      'category' => $category,
      'attributes' => AttributesResource::collection(Attribute::where(['category_id' => $request->category_id])->get()),
      'price_conditions' => TimeResource::collection(TimePeriod::where(['category_id' => $request->category_id])->get()),
      'address' => new AddressResource($address->address)
    ];
  }
  public function store(Request $request)
  {
    $user = Auth::user();
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'description' => 'required',
      'category' => 'required',
      'rent_price' => 'required',
      'images' => 'required',
      'price_condition' => 'required',
      'security_price' => 'required',
      'address' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
    } else {
      $data = array(
        'id' => Carbon::now()->timestamp,
        'name' => $request->name,
        'user_id' => $this->uid(),
        'slug' => Str::slug($request->name),
        'base_url' => Str::slug($request->name),
        'category_id' => $request->category,
        'description' => $request->description,
        'rent_price' => $request->rent_price,
        'time_id' => $request->price_condition,
        'security_price' => $request->security_price,
        'from_date' => date('y-m-d h:i:s'),
        'to_date' => date('y-m-d h:i:s'),
      );

      $item = Item::create($data);
      if ($item) {
        if (count($request['attributes']) > 0) {
          foreach ($request['attributes'] as $attribute) {
            ItemAttribute::create(['item_id' => $item->id, 'attribute_id' => $attribute['attribute'], 'attribute_value' => $attribute['value']]);
          }
        }
        // $address = Address::create([
        //   'country' => 'IN',
        //   'address' => $request->address['address'],
        //   'locality' => $request->address['locality'],
        //   'state' => $request->address['state'],
        //   'city' => $request->address['city'],
        //   'pincode' => $request->address['pincode'],
        //   'latitude' => $request->address['latitude'],
        //   'longitude' => $request->address['longitude'],
        // ]);
        if (true) {
          $notification = new NewPostNotification($item);

          $user->notify($notification);

          // event(new PostAdsEvent(['data' => $item]));
          return response()->json(['message' => 'Item has been added successfully', 'data' => $item, 'success' => true]);
        }
        return response()->json(['message' => 'Opps someting wrong! please try again', 'success' => false]);
      }
    }
  }
  public function success(Request $request)
  {
    $item = Item::where(['id' => $request->adid, 'user_id' => auth()->user()->id])->first();

    if ($item) {
      return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
  }

  public function edit(Request $request)
  {
    if ($request->pid) {
      $item = Item::where(['id' => $request->pid])->first();
      if ($item) {
        $category = Category::find($item->category_id);
        return [
          'category' => $category,
          'attributes' => AttributesResource::collection(Attribute::where(['category_id' => $category->id, 'parent_id' => null])->get()),
          'price_conditions' => TimeResource::collection(TimePeriod::where(['category_id' => $category->id])->get()),
          'data' => $item,
        ];
      }
    }
    return response()->json(['data' => null]);
  }
  public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'description' => 'required',
      'rent_price' => 'required',
      'images' => 'required',
      'price_condition' => 'required',
      'security_price' => 'required',
      'address' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
    } else {
      $data = array(
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'description' => $request->description,
        'rent_price' => $request->rent_price,
        'time_id' => $request->price_condition,
        'security_price' => $request->security_price,
        'from_date' => date('y-m-d h:i:s'),
        'to_date' => date('y-m-d h:i:s'),
      );
      $item = Item::where(['id' => $request->pid, 'user_id' => $this->uid()])->update($data);
      if ($item) {
        ItemAttribute::where(['item_id' => $request->pid])->delete();
        if (count($request['attributes']) > 0) {
          foreach ($request['attributes'] as $attribute) {
            ItemAttribute::create(['item_id' => $request->pid, 'attribute_id' => $attribute['attribute'], 'attribute_value' => $attribute['value']]);
          }
        }
        $address = ItemLocation::where([
          'item_id' => $request->pid
        ])->first();
        if (Address::where('id', $address->id)->update([
          'country' => 'IN',
          'address' => $request->address['address'],
          'locality' => $request->address['locality'],
          'state' => $request->address['state'],
          'city' => $request->address['city'],
          'pincode' => $request->address['pincode'],
          'latitude' => $request->address['latitude'],
          'longitude' => $request->address['longitude'],
        ])) {
          // ItemImage::where(['item_id' => $request->pid])->delete();
          // foreach ($request->images as $image) {
          //   ItemImage::create([
          //     'item_id' => $request->pid,
          //     'image_id' => $image['id'],
          //   ]);
          // }
          return response()->json(['message' => 'Item has been added successfully', 'data' => $request->pid, 'success' => true]);
        }
      }
      return response()->json(['message' => 'Opps someting wrong! please try again', 'success' => false]);
    }
  }
}
