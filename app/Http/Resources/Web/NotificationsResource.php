<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NotificationsResource extends JsonResource
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
            'data' => $this->data,
            'created' => $this->getTimeDifference(),
        ];
    }

    private function getTimeDifference()
    {
        $createdAt = Carbon::parse($this->created_at);
        $now = Carbon::now();

        // Calculate the difference in seconds, minutes, hours, etc.
        $diffInMinutes = $createdAt->diffInMinutes($now);
        $diffInHours = $createdAt->diffInHours($now);
        $diffInDays = $createdAt->diffInDays($now);

        if ($diffInMinutes < 60) {
            return $diffInMinutes . ' minutes';
        } elseif ($diffInHours < 24) {
            return $diffInHours . ' hours';
        } else {
            return $diffInDays . ' days';
        }
    }
}
