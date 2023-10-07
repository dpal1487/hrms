<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'email_verified_at' => $this->email_verified_at ? true : false,
            'country' => $this->country?->name,
            'image' => new ImageResource($this->image),
            'header' => [
                'total_ads' => $this->total_ads ? count($this->totaladds) : 0,
                'followers' => $this->followers ? count($this->followers) : 0,
                'following' => $this->following ? count($this->following) : 0,
            ]
        ];
    }
}
