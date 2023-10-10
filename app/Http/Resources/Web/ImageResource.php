<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $baseUrl = $request->root();
        $protocol = $request->getScheme();
        $hostname = $request->getHost();
        $port = $request->getPort(); // remove in production

        $filepath =  $protocol . "://" . $hostname . ":" . $port . "/" . $this->base_path . 'original/'. $this->name;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->base_url,
            'file_path' => $filepath,
            'base_path' => $this->base_path.'original/',
            'small_path' => $this->base_url . '/' . $this->base_path . '150px/' . $this->name . '?width=100&height=100',
            'medium_path' => $this->base_url . '/' . $this->base_path . '300px/' . $this->name . '?width=200&height=200',
            'large_path' => $this->base_url . '/' . $this->base_path . '600px/' . $this->name . '?width=1024',
        ];
    }
}
