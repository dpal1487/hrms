<?php

namespace App\Http\Controllers\Web;

use App\Http\Resources\Web\NotificationResource;
use App\Models\Notification;
use App\Notifications\NewPostNotification;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Notifications\Notifiable;

class HomeController extends Controller
{
    use Notifiable;
    public function index()
    {
        
        $adminNotifications = Notification::orderBy('created_at', 'desc')->take(20)->get();
        
        return Inertia::render('Dashboard',[
            'notifications' =>NotificationResource::collection($adminNotifications),
            'headers' => [
                'count' => $adminNotifications->count(),
            ],        
        ]);
    }
}
