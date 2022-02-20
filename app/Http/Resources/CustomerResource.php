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
                'email_address' => $this->email,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'employment_status' => $this->employment_status,
                'reg_id' => $this->reg_id,
                'date_of_registration' => $this->date_of_registration,
                'civil_status' => $this->civil_status
            ],
            'relationships' => [],
            'included' => [
                'orders' => OrderResource::collection($this->whenLoaded('orders')),
            ]
        ];
    }
}
