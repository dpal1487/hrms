<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'title' => $this->name,
      'slug' => $this->slug,
      'base_url' => $this->base_url,
      'description' => $this->description,
      'rent_price' => $this->rent_price,
      'time_id' => $this->time_id,
      'security_price' => $this->security_price,
      'from_date' => $this->from_date,
      'to_date' => $this->to_date,
      'category' => $this->category,
      'time' => $this->time?->title,
      'user' => $this->user,
      'status' => $this->status,

      // 'images' => ItemImagesResource::collection(image->file->file_name),

      'images' => [
        'file_name' => $this->image?->file?->file_name,
        'file_path' => $this->image?->file?->file_path,
        'file_size' => $this->image?->file?->file_size,
        'file_mime' => $this->image?->file?->file_mime,
        'file_extension' => $this->image?->file?->file_extension,
        'status' => $this->image?->file?->status,
      ],

      // 'user' => UserResource::collection($this->user),
      // 'location' => new ItemLocationsResource($this->location),

      'currency_symbol' => $this->user?->country?->currency_symbol,
      'rating_reviews' => count($this->reviews) > 0 ? [
        // 'rating' => round($this->placeRating($this->reviews), 1),
        'count' => count($this->reviews)
      ] : [
        'rating' => 0,
        'count' => 0
      ],
      'location' => [
        'id' => $this->location?->address?->id,
        'address_line_1' => $this->location?->address?->address_line_1,
        'address_line_2' => $this->location?->address?->address_line_2,
        'city' => $this->location?->address?->city,
        'state' => $this->location?->address?->state,
        'country' => $this->location?->address?->country,
        'pincode' => $this->location?->address?->pincode,
      ],
      'isFavourite' => $this->isFavourite ? true : false,
    ];
  }
}
