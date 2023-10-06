<?php

namespace App\Listeners;

use App\Events\ItemAddedToFavorite;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class AddItemToFavoritesListener
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
     * @param  \App\Events\ItemAddedToFavorite  $event
     * @return void
     */
    public function handle(ItemAddedToFavorite $event)
    {
        $user = $event->user;
        $item = $event->item;

        // Assuming you have a 'favorites' table, you can add a record to it.
        $itemAddedToFavorite =  $user->favorites()->attach($item->id);

        // You can also send a response or perform any other necessary actions here.

        Http::post("http://192.168.1.16:4000/item-added-to-favorite", [
            'itemAddedToFavorite' => $itemAddedToFavorite,
        ]);

    }
}
