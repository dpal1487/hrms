<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Category;
use App\Models\State;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Resources\Api\Categories;
use App\Http\Resources\Notifications;
use App\Http\Resources\States;

class AppController extends Controller
{
  public function index(Request $request)
  {
    $page = $request->page;
    $this->data['notification'] = [
      'data' => [],
      'count' => 0
    ];
    try {
      if ($user) {
        $notifications = Notification::where(['recipient_id' => $this->uid(), 'deleted' => 0, 'is_read' => 0])->get();
        $this->data['notification'] = [
          'data' => Notifications::collection($notifications),
          'count' => count($notifications)
        ];
      }
    } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

      // do whatever you want to do if a token is expired

    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

      // do whatever you want to do if a token is invalid

    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

      // do whatever you want to do if a token is not present
    }
    $this->data['categories'] = Categories::collection(Category::with('image', 'childrens.image')->where('parent_id', 0)->get());
    $this->data['states'] = States::collection(State::where(['country_id' => 101])->get());
    return response()->json($this->data);
  }
}
