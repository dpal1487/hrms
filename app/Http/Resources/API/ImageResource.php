<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $baseUrl = $request->root();
        $protocol = $request->getScheme();
        $hostname = $request->getHost();
        $port = $request->getPort(); // remove in production
        $filepath =  $protocol . "://" . $hostname . ":" . $port . "/" . $this->base_path . $this->name;  // remove in production
        //$filepath = $this->base_url . '/' . $this->base_path . $this->name;
        return [
            'id' => $this->id,
            'url' => $filepath,
        ]; 
    }
}
