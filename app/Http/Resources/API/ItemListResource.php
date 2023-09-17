<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\Account\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'base_url' => $this->base_url,
            'category' => [
                'name'=>$this->category->name,
                'slug'=>$this->category->slug,
            ],
            'period' =>$this->time->title,
            'image' => new ImageResource($this->image),
            'rent_price' => $this->rent_price,
            'security_price' => $this->security_price,
            'currency_symbol' => $this->user->country->currency_symbol,
            'rating_reviews' => count($this->reviews) > 0 ? [
                'rating' => round($this->placeRating($this->reviews), 1),
                'count' => count($this->reviews)
            ] : [
                'rating' => 0,
                'count' => 0
            ],
            'location' => new AddressResource($this->location),
            'isFavourite' => $this->isFavourite ? true : false,
        ];
    }
    public function placeRating($reviews)
    {
        $ratingValues = [];
        foreach ($reviews as $aRating) {
            $ratingValues[] = $aRating->rating;
        }
        $ratingAverage = collect($ratingValues)->sum() / $reviews->count();

        return $ratingAverage;
    }
}
