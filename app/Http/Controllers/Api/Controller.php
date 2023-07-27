<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use JWTAuth;

abstract class Controller extends BaseController
{
  use ValidatesRequests;
  public function errorMessage()
  {
    return response()->json(['success' => false, 'type' => 'error', 'message' => 'Something went wrong. Try again']);
  }
  public function successMessage($message)
  {
    return response()->json(['success' => true, 'type' => 'success', 'message' => $message]);
  }
  public function uid()
  {
    $user = Auth::guard('api')->user();
    return $user->id;
  }
  public function user()
  {
    return Auth::guard('api')->user();
  }


  public function getTokenId()
  {
    $user = Auth::user();
    $token = $user->currentAccessToken();

    if ($token) {
      return $token->tokenable_id;
    } else {
      return response()->json(['error' => 'Token not found.'], 404);
    }
  }
}
