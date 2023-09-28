<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Events\NotificationCreated;
use App\Http\Resources\Web\NotificationsResource;
use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        $notification = Notification::orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return response()->json(['success' => true, 'data' => NotificationsResource::collection($notification)]);
    }
}
