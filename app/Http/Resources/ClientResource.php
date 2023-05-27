<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'id' => $this->c_id,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'sort_name' => $this->sort_name,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
