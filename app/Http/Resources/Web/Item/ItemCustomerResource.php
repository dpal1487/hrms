<?php

namespace App\Http\Resources\Web\Item;

use App\Http\Resources\Web\ImageResource;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemCustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'image' => new ImageResource($this->image),
            'item_details' => $this->customer->item,
            'item_customer' => ItemResource::collection($this->customers),
            'category' => $this->category,
            'total_customers' => count($this->customers) > 0 ? [
                'count' => count($this->customers)
            ] : [
                'count' => 0
            ],
        ];
    }
}
