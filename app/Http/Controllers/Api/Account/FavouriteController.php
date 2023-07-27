<?php

namespace App\Http\Controllers\Api\Account;


use App\Models\Favourite;
use App\Http\Resources\Api\Account\Favourites;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\FavouritesResource;

class FavouriteController extends Controller
{
  public $offset, $limit;

  function __construct($offset = 0, $limit = 10)
  {
    $this->offset = $offset;
    $this->limit = $limit;
  }
  public function index(Request $request)
  {
    $favourites = Favourite::whereHas('item', function ($q) {
      $q->where('is_deleted', 0);
    })->orderBy('id', 'desc')->where('user_id', $this->uid());
    $this->data['totalCount'] = $favourites->count();
    if ($this->offset) {
      $favourites = $favourites->skip($this->offset);
    }
    $favourites = $favourites->get();

    // return $favourites;
    $this->data['data'] = FavouritesResource::collection($favourites);
    return response()->json($this->data);
  }
  public function store($id)
  {
    if (Favourite::create(['user_id' => $this->uid(), 'item_id' => $id])) {
      return response()->json([
        'message' => "Your Item Has Been Added To Shortlist.",
        'success' => true
      ]);
    }
    return response()->json(['success' => false, 'message' => 'Faild to Add Shortlist.'], 400);
  }
  public function destroy($id)
  {

    if (Favourite::where(['item_id' => $id, 'user_id' => $this->uid()])->delete()) {
      return response()->json(['success' => true, 'message' => 'Item removed from wishlist successfully.']);
    }
    return response()->json(['success' => false, 'message' => 'Faild to Remove Shortlist.'], 400);
  }
}
