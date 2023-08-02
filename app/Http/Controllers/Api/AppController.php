<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Account\NotificationsResource;
use App\Models\Category;
use App\Models\State;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\StatesResource;
use App\Models\User;

class AppController extends Controller
{
  public $data;
  public function index(Request $request)
  {
    $page = $request->page;
    $this->data['notification'] = [
      'data' => [],
      'count' => 0
    ];
    try {
      $user = User::where(['id' => $this->uid()])->first();
      if ($user) {
        $notifications = Notification::where(['recipient_id' => $this->uid(), 'deleted' => 0, 'is_read' => 0])->get();
        $this->data['notification'] = [
          'data' => NotificationsResource::collection($notifications),
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
    $this->data['categories'] = CategoryResource::collection(Category::with('image', 'childrens.image')->where('parent_id', 0)->get());
    $this->data['states'] = StatesResource::collection(State::where(['country_id' => 101])->get());
    return response()->json($this->data);
  }
}
