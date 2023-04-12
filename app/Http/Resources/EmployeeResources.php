<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResources extends JsonResource
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
            'id' => $this->id,
            'code' => $this->code,
            'date_of_joining' => $this->date_of_joining,
            'number' => $this->number,
            'qualification' => $this->qualification,
            'emergency_number' => $this->emergency_number,
            'pan_number' => $this->pan_number,
            'father_name' => $this->father_name,
            'formalities' => $this->formalities,
            'salary' => $this->salary,
            'offer_acceptance' => $this->offer_acceptance,
            'probation_period' => $this->probation_period,
            'date_of_confirmation' => $this->date_of_confirmation,
            'notice_period' => $this->notice_period,
            'last_working_day' => $this->last_working_day,
            'full_final' => $this->full_final,
            'department_id' => $this->department_id,
            'created_at' => $this->created_at,
            'user' => $this->user,
        ];
    }
}
