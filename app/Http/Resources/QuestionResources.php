<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResources extends JsonResource
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
            'question_key' => $this->question_key,
            'text' => $this->text,
            'language' => $this->language,
            'type' => $this->type,
            'industry' => $this->industry,
        ];
    }
}
