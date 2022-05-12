<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VerificationResource extends JsonResource
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
            'id_card' => (bool) $this->id_card,
            'passport' => (bool) $this->passport,
            'guarantor_id' => (bool) $this->guarantor_id,
            'proof_of_income' => (bool) $this->proof_of_income,
        ];
    }
}
