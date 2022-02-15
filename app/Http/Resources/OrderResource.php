<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'type' => 'orders',
            'attributes' => [
                'order_number' => $this->order_number,
                'order_date' => $this->order_date,
                'product_price' => $this->product_price,
                'down_payment' => $this->down_payment,
                'repayment' => $this->repayment,
            ],
            'relationships' => [],
            'included' => [
                'amortizations' => $this->amortizations,
                'product' => $this->product,
            ]
        ];
    }
}
