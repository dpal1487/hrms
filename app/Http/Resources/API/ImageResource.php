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
            'name' => $this->name,
            'url' => $this->base_url,
            'file_path' => $filepath,
            'base_path' => $this->base_path,
        ]; 
    }
}
