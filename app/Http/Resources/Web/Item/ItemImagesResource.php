<?php

namespace App\Http\Resources\Web\Item;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemImagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'file_name' => $this->image->file->file_name,
            'file_path' => $this->image->file->file_path,
            'file_size' => $this->image->file->file_size,
            'file_mime' => $this->image->file->file_mime,
            'file_extension' => $this->image->file->file_extension,
            'status' => $this->image->file->status,
        ];
    }
}
