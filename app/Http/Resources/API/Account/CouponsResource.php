<?php

namespace App\Http\Resources\Api\Account;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponsResource extends JsonResource
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
            "id" => $this->id,
            "code" => $this->code,
            "descriptions" => $this->descriptions,
            "type" => $this->type,
            "discount" => $this->discount,
            "expires_at" => date('y M d m:s', strtotime($this->expires_at)),
            "created_at" => date('y M d m:s', strtotime($this->created_at)),
            "updated_at" => date('y M d m:s', strtotime($this->updated_at))
        ];
    }
}
