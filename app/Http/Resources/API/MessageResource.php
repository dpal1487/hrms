<?php

namespace App\Http\Resources\Api;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'conversation_id'=>$this->conversation_id,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'time_ago' => $this->created_at->diffForHumans(),
            'sender_id'=>$this->sender_id,
            'body'=>$this->body,
            'attachment'=>$this->attachment,
            'seen'=>$this->seen
        ];
    }
}
