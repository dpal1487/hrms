<?php

namespace App\Http\Resources\Web\Item;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemRatingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'five_star' => count($this->review->where('rating', 5)->get()),
            'foure_star' => count($this->review->where('rating', 4)->get()),
            'three_star' => count($this->review->where('rating', 3)->get()),
            'two_star' => count($this->review->where('rating', 2)->get()),
            'one_star' => count($this->review->where('rating', 1)->get()),
        ];
    }
}
