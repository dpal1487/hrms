<?php

namespace App\Listeners;

use App\Events\ItemReviewed;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ItemReviewedListener
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
     * @param  \App\Events\ItemReviewed  $event
     * @return void
     */
    public function handle(ItemReviewed $event)
    {


        $user = $event->user;
        $item = $event->item;

        // Assuming you have a 'favorites' table, you can add a record to it.
        $itemReviewedData = $user->reviews()->attach($item->id);

        // You can also send a response or perform any other necessary actions here.

        return $itemReviewedData;

        // Emit the event to Socket.io server
        Http::post("http://192.168.1.16:4000/notification-created", [
            'notificationData' => $itemReviewedData,
        ]);
    }
}
