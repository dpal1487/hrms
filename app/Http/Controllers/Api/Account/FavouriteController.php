<?php

namespace App\Http\Controllers\Api\Account;

use App\Events\ItemAddedToFavorite;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Account\FavouriteListResource;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
  public $offset, $limit, $data;

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
    //$this->data['totalCount'] = $favourites->count();
    if ($this->offset) {
      $favourites = $favourites->skip($this->offset);
    }
    $favourites = $favourites->get();
    $this->data['data'] = FavouriteListResource::collection($favourites);
    return response()->json($this->data);
  }
  public function store($id)
  {

    // Logic to add the item to favorites
    $user = Auth::user(); // Assuming you are using authentication
    $item = Item::find($id);

    // if (Favourite::create(['user_id' => $this->uid(), 'item_id' => $id])) {
    //   return response()->json([
    //     'message' => "Your Item Has Been Added To Shortlist.",
    //     'success' => true
    //   ]);

      // Trigger the event
      event(new ItemAddedToFavorite($user, $item));
    // }
    // return response()->json(['success' => false, 'message' => 'Faild to Add Shortlist.'], 400);
  }

  public function testAddItemToFavorites()
  {
    $user = User::factory()->create();
    $item = Item::factory()->create();

    $response = $this->actingAs($user)
      ->post(route('addToFavorites', ['itemId' => $item->id]));

    $response->assertStatus(200);
    // Add more assertions based on your application's behavior
  }

  public function destroy($id)
  {
    if (Favourite::where(['item_id' => $id, 'user_id' => $this->uid()])->delete()) {
      return response()->json(['success' => true, 'message' => 'Item removed from wishlist successfully.']);
    }
    return response()->json(['success' => false, 'message' => 'Faild to Remove Shortlist.'], 400);
  }
}
