<?php

namespace App\Listeners;

use App\Events\NotificationCreated;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationCreatedEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NotificationCreated $event)
    {
        $notificationData = $event->getNotificatio;


        return $notificationData;

        // Emit the event to Socket.io server
        Http::post("http://192.168.1.16:4000/notification-created", [
            'notificationData' => $notificationData,
        ]);
    }
}
