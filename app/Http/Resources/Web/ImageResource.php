<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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

        $filepath =  $protocol . "://" . $hostname . ":" . $port ."/". $this->base_path . $this->name;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->base_url,
            'file_path' => $filepath,
            'base_path' => $this->base_path,
            'small_path' => $filepath . "?width=100&height=100",
            'medium_path' => $filepath . "?width=200&height=200",
            'large_path' => $filepath . "?width=1024",
        ];
    }
}
