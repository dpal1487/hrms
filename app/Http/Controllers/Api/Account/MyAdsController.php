<?php

namespace App\Http\Controllers\Api\Account;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemStatus;
use App\Models\Subscription;
use App\Http\Resources\Api\MyAds\MyAds;
use App\Http\Resources\Api\Status;
use App\Http\Resources\Api\Subscriptions;

class MyAdsController extends Controller
{
  public function index(Request $request)
  {
    $items = Item::orderBy('id', 'desc')->where(['user_id' => $this->uid(), 'is_deleted' => 0])->orderBy('id', 'desc');
    $count = $items->count();
    if ($request->filter == 'active') {
      $items->where('status_id', 1);
    }
    if ($request->filter == 'pending') {
      $items->where('status_id', 2);
    }
    if ($request->filter == 'rejected') {
      $items->where('status_id', 3);
    }
    if ($request->filter == 'featured') {
      $items->where('status_id', 4);
    }
    if ($request->filter == 'deactivated') {
      $items->where('status_id', 5);
    }
    if (!empty($request->keyword)) {
      $items->where('name', 'LIKE', "%$request->keyword%");
    }
    $items = $items->paginate(20)->setPath('/myads')->appends($request->all());
    return MyAds::collection($items)->additional(['filters' => Status::collection(ItemStatus::all()), 'totalCounts' => $count]);
  }
  public function delete($id)
  {
    if (Item::where(['id' => $id, 'user_id' => $this->uid()])->first()) {
      $item = Item::where(['id' => $id, 'user_id' => $this->uid()])->update(['is_deleted' => 1]);
      if ($item) {
        return response()->json(['success' => true, 'message' => 'Your item removed from listing successfully.']);
      }
      return response()->json(['success' => false, 'message' => 'Faild to Remove Listing.'], 400);
    }
  }
  public function deactivate($id)
  {
    if (Item::where(['id' => $id, 'user_id' => $this->uid()])->first()) {
      $item = Item::where(['id' => $id, 'user_id' => $this->uid()])->orWhereIn(['status_id'=>[1,4]])->update(['status_id' => 5]);
      if ($item) {
        return response()->json(['success' => true, 'message' => 'Your item deactivate from listing successfully.']);
      }
      return response()->json(['success' => false, 'message' => 'Faild to deactivate listing.'], 400);
    }
  }
  public function activate($id)
  {
    if (Item::where(['id' => $id, 'user_id' => $this->uid(),'status_id'=>5])->first()) {
      $item = Item::where(['id' => $id, 'user_id' => $this->uid()])->update(['status_id' => 2]);
      if ($item) {
        return response()->json(['success' => true, 'message' => 'Your Item wating for activate.']);
      }
      return response()->json(['success' => false, 'message' => 'Faild to Activate Item.'], 400);
    }
  }
  public function rentFaster()
  {
    $subscriptions = Subscription::where(['user_id' => $this->uid()])->get();
    if(count($subscriptions)>0){
      foreach($subscriptions as $subscription){

      }
    }
  }
}
