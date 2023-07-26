<?php

namespace App\Http\Controllers\Api\Account;


use Illuminate\Http\Request;
use App\Http\Resources\Api\Account\Reviews;
use JWTAuth;
use App\Models\ItemReview;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\ItemResource;
use App\Http\Resources\Api\Items;
use App\Http\Resources\Api\ReviewsResource;
use App\Models\Item;

class ReviewController extends Controller
{
  public $data;
  public function index(Request $request, $id)
  {

    $star  = 0;
    $ratingCount = 0;
    $reviews = ItemReview::where('item_id', $id)->orderBy('id', 'desc');
    $item = Item::find($id);
    $ratings = $reviews->get();

    // return $ratings;
    foreach ($ratings as $rating) {
      $star = $star + $rating->rating;
      $ratingCount = $ratingCount + $rating->rating;
    }
    if (count($ratings) > 0) {
      $avg = $star / count($ratings);

      $this->data = array(
        'average_rating' => $avg,
        'count' => count($ratings),
        'ratingCount' => $ratingCount
      );
    }
    return ReviewsResource::collection($reviews->paginate(1)->setPath("/item/{$item->slug}/$id"))->additional(['ratings' => $this->data]);
  }
  public function myReviews()
  {
    $reviews = ItemReview::where('user_id', $this->uid())->get();

    return ReviewsResource::collection($reviews)->additional(['totalReviews' => count($reviews)]);
  }
  public function edit($id)
  {
    $review = ItemReview::with('review')->where(['item_id' => $id, 'user_id' => $this->uid()])->first();

    if ($review) {
      $this->data['data'] = [
        'title' => $review->title,
        'content' => $review->content,
        'rating' => $review->rating,
      ];
    } else {
      $this->data['data'] = [
        'title' => '',
        'content' => '',
        'rating' => '',
      ];
    }
    $this->data['item'] = new ItemResource(Item::where(['id' => $id])->first());
    return response()->json($this->data);
  }
  public function createOrUpdate(Request $request, $id)
  {
    if ($item = ItemReview::where(['item_id' => $id, 'user_id' => $this->uid()])->first()) {
      if (Review::where(['id' => $item->review_id])->update(['content' => $request->content, 'rating' => $request->rating, 'title' => $request->title])) {
        return response()->json(['success' => true, 'message' => 'Review added successfully']);
      }
    } else {
      if ($review = Review::create(['content' => $request->content, 'rating' => $request->rating, 'title' => $request->title])) {
        if (ItemReview::create(['item_id' => $id, 'user_id' => $this->uid(), 'review_id' => $review->id])) {
          return response()->json(['success' => true, 'message' => 'Review added successfully']);
        }
      }
    }
    return response()->json(['success' => false, 'message' => 'Faild to added Review.'], 400);
  }
  public function remove($id)
  {

    if ($review = ItemReview::where(['item_id' => $id, 'user_id' => $this->uid()])->first()) {

      if (ItemReview::where(['id' => $id])->delete() && Review::where(['id' => $review->review_id])->delete()) {
        return response()->json(['success' => true, 'message' => 'Review deleted successfully']);
      }
    }
    return response()->json(['success' => false, 'message' => 'Faild to Delete Review.'], 400);
  }
  public function report($id)
  {
    if ($review = ItemReview::where(['id' => $id, 'user_id' => $this->uid()])->first()) {
      if (ItemReview::where(['id' => $id])->delete() && Review::where(['id' => $review->review_id])->delete()) {
        return response()->json(['success' => true, 'message' => 'Review deleted successfully']);
      }
    }
    return response()->json(['success' => false, 'message' => 'Faild to Delete Review.'], 400);
  }
}
