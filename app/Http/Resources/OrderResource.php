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
                'customer_id' => $this->customer_id,
            ],
            'relationships' => [],
            'included' => [
                'amortizations' => $this->amortizations,
                'product' => $this->product,
                'business_type' => $this->businessType,
                'down_payment_rate' => $this->downPaymentRate,
                'order_type' => $this->orderType,
                'repayment_duration' => $this->repaymentDuration,
                'sales_category' => $this->salesCategory,
                'repayment_cycle' => $this->repaymentCycle,
                'late_fees' => $this->lateFee
            ]
        ];
    }
}
