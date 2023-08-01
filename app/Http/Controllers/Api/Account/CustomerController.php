<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\CustomersResource;
use App\Models\ItemCustomer;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
  public function index($id)
  {
    if (Item::where(['id' => $id, 'user_id' => $this->uid()])->first()) {
      $customers = ItemCustomer::with('document')->where(['item_id' => $id])->get();
      return CustomersResource::collection($customers);
    }
  }
  public function sendOtp(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'pid' => 'required',
      'name' => 'required',
      'mobile' => 'required',
      'security_pay' => 'required',
      'email_address' => 'required',
      'document' => 'required'
    ]);
    if ($validator->fails()) {
      return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
    }
    if (ItemCustomer::create([
      'item_id' => $request->pid,
      'full_name' => $request->name,
      'mobile' => $request->mobile,
      'security_pay' => $request->security_pay,
      'email_address' => $request->email_address,
      'end_date' => $request->end_date,
      'document_id' => 1
    ])) {
      return response()->json([
        'success' => true,
        'message' => 'Customer added successfully',
      ], 200);
    } else {
      return response()->json([
        'success' => false,
        'message' => 'Failed to add Customer.',
      ]);
    }
  }
}
