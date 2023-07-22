<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemListResource extends JsonResource
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
            'id'=>$this->id,
            'menu'=>$this->menu,
            'title'=>$this->title,
            'url'=>$this->url,
            'target'=>$this->target,
            'icon_class'=>$this->icon_class,
            'color'=>$this->color,
            'parent'=>$this->parent,
            'order_by'=>$this->order_by,
            'route'=>$this->route,
            'parameters'=>$this->parameters,
        ];
    }
}
