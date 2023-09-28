<?php

namespace App\Http\Controllers\Api\Account;


use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Account\AddressResource;
use App\Http\Resources\Api\StatesResource;
use App\Models\State;
use App\Models\User;
use Faker\Provider\UserAgent;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
  public function index()
  {
    $addresses = [];
    $states = StatesResource::collection(State::where('country_id',101)->orderBy('name', 'asc')->get());
    if ($addresses = Address::whereHas('address',function($q){
      $q->where(['user_id' => $this->uid()]);
    })->latest()->get()) {
      $addresses = AddressResource::collection($addresses);
    }
    return response()->json(['data' => $addresses,'states'=>$states, 'success' => true]);
  }
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'address' => 'required',
      'phone' => 'required|numeric',
      'city' => 'required',
      'state' => 'required|exists:states,name',
      'pincode' => 'required|string',
      'address_type' => 'required|string',
    ]);
    if ($validator->fails()) {
      return response()->json(['success' => false, 'message' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
    }
    if($request->is_primary){
      $addresses =  UserAddress::where('user_id',$this->uid())->latest()->get();
      foreach ($addresses as $address) {
        $address->address->update(['is_primary'=>0]);
    }
    }
    $data = [
      'address' => $request->address,
      'name' => $request->name,
      'phone' => $request->phone,
      'address_type_id' => $request->address_type,
      'is_primary' => $request->is_primary ? 1 : 0 ,
      'city' => $request->city,
      'state' => $request->state,
      'latitude' => $request->latitude,
      'longitude' => $request->longitude,
      'pincode' => $request->pincode,
    ];
    if ($address = Address::create($data)) {
        UserAddress::create(['user_id' => $this->uid(), 'address_id' => $address->id]);
        return response()->json([
          'success' => true,
          'message' => CreateMessage("Address"),
        ], Response::HTTP_OK);
    }
    return response()->json([
      'success' => false,
      'message' => FailedUpdateMessage('address'),
    ],Response::HTTP_BAD_REQUEST);
  }
  public function update(Request $request,$id)
  {
    $validator = Validator::make($request->all(), [
      'address' => 'required',
      'phone' => 'required|numeric',
      'city' => 'required',
      'state' => 'required|exists:states,name',
      'pincode' => 'required|string',
      'address_type' => 'required|string',
    ]);
    if ($validator->fails()) {
      return response()->json(['success' => false, 'message' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
    }
    if($request->is_primary){
      $addresses =  UserAddress::where('user_id',$this->uid())->latest()->get();
      foreach ($addresses as $address) {
        $address->address->update(['is_primary'=>0]);
    }
    }
    $data = [
      'address' => $request->address,
      'name' => $request->name,
      'phone' => $request->phone,
      'address_type_id' => $request->address_type,
      'is_primary' => $request->is_primary ? 1 : 0 ,
      'city' => $request->city,
      'state' => $request->state,
      'latitude' => $request->latitude,
      'longitude' => $request->longitude,
      'pincode' => $request->pincode,
    ];
    if (Address::where('id',$id)->update($data)) {
        return response()->json([
          'success' => true,
          'message' => UpdateMessage("Address"),
        ], Response::HTTP_OK);
    }
    return response()->json([
      'success' => false,
      'message' => FailedUpdateMessage('address'),
    ],Response::HTTP_BAD_REQUEST);
  }
  public function delete($id)
  {
    if($address = UserAddress::where(['user_id' => $this->uid(), 'address_id' => $id])->first()) {
      $address->delete();  
      $address->address->delete();
      return response()->json([
        'success' => true,
        'message' => DeleteMessage("address"),
      ], Response::HTTP_OK);
    }
    return response()->json([
      'success' => false,
      'message' => FailedDeleteMessage("message"),
    ], Response::HTTP_BAD_REQUEST);
  }
}
