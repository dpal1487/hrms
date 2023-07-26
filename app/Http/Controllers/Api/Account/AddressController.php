<?php

namespace App\Http\Controllers\Api\Account;


use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\AddressResource;
use App\Http\Resources\States;
use App\Models\State;

class AddressController extends Controller
{
  public function index()
  {
    if ($address = UserAddress::where(['user_id' => $this->uid()])->first()) {
      return response()->json(['data' => new AddressResource($address->address), 'success' => true]);
    }
    return response()->json(['data' => null, 'success' => true]);
  }
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'address_line_1' => 'required',
      'address_line_2' => 'required',
      'city' => 'required',
      // 'locality' => 'required',
      'state' => 'required',
      'pincode' => 'required|string'
    ]);
    if ($validator->fails()) {
      return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
    }
    if (!UserAddress::where('user_id', $this->uid())->first()) {
      if ($address = Address::create([
        'address_line_1' => $request->address_line_1,
        'address_line_2' => $request->address_line_2,
        'city' => $request->city,
        'country_id' => 101,
        'state' => $request->state,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'pincode' => $request->pincode,
      ])) {
        UserAddress::create(['user_id' => $this->uid(), 'address_id' => $address->id]);
        return response()->json([
          'success' => true,
          'message' => 'Address updated successfully.',
        ], Response::HTTP_OK);
      }
    } else {
      $address = UserAddress::where(['user_id' => $this->uid()])->first();
      if (Address::where(['id' => $address->address_id])->update([
        'address_line_1' => $request->address_line_1,
        'address_line_2' => $request->address_line_2,
        'city' => $request->city,
        'country_id' => 101,
        'state' => $request->state,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'pincode' => $request->pincode,
      ])) {
        return response()->json([
          'success' => true,
          'message' => 'Address updated successfully',
        ], Response::HTTP_OK);
      }
    }
    return response()->json([
      'success' => false,
      'message' => 'Failed to update Address.',
    ], 400);
  }
  public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'address' => 'required',
      'city' => 'required|exists:cities,name',
      'locality' => 'required',
      'state' => 'required|exists:states,name',
      'pincode' => 'required|string'
    ]);
    if ($validator->fails()) {
      return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
    }
    if ($address = UserAddress::where(['user_id' => $this->uid()])->first()) {
      if (Address::where(['id' => $address->id])->update([
        'address' => $request->address,
        'locality' => $request->locality,
        'city' => $request->city,
        'country' => 'IN',
        'state' => $request->state,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'pincode' => $request->pincode,
      ])) {

        return response()->json([
          'success' => true,
          'message' => 'Address updated successfully',
        ], Response::HTTP_OK);
      }
    }
    return response()->json([
      'success' => false,
      'message' => 'Failed to update Address.',
    ], 400);
  }
  public function delete($id)
  {
    if (Address::where(['user_id' => $this->uid(), 'id' => $id])->delete()) {
      $address =  Address::where(['user_id' => $this->uid()])->orderBy('id', 'desc');
      $address->update(['user_id' => $this->uid(), 'is_primary' => false]);
      $address->take(1)->update(['user_id' => $this->uid(), 'is_primary' => true]);
      return response()->json([
        'success' => true,
        'message' => 'Address deleted successfully',
      ], Response::HTTP_OK);
    }
    return response()->json([
      'success' => false,
      'message' => 'Failed to delete Address.',
    ], 400);
  }
}
