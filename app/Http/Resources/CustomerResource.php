<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'type' => 'customers',
            'attributes' => [
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'phone_number' => $this->telephone,
                'on_boarded' => (bool) $this->on_boarded,
                'email_address' => $this->email,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'employment_status' => $this->employment_status,
                'reg_id' => $this->reg_id,
                'date_of_registration' => $this->date_of_registration,
                'civil_status' => $this->civil_status,
                'add_street' => $this->add_street,
                'city' => $this->city,
                'state' => $this->state,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'staff_id' => $this->user_id,

            ],
            'relationships' => [],
            'included' => [
                'orders' => OrderResource::collection($this->whenLoaded('orders')),
            ]
        ];
    }
}
