<?php

namespace App\Http\Resources\Api\Account;

use App\Http\Resources\Api\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'phonecode'=>$this->country->phonecode,
            'about' => $this->about,
            'isVerified' => $this->is_verified,
            'total_ads' => count($this->items),
            'followers' => [
                'followerCount' => count($this->followers),
                'followingCount' => count($this->following),
            ],
            'image' => new ImageResource($this->image),
        ];
    }
}
