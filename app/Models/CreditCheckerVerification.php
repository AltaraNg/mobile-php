<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreditCheckerVerification extends Model
{
    use HasFactory;

    const PENDING = 'pending';
    const PASSED = 'passed';
    const FAILED = 'failed';
    const STATUSES = [self::PENDING, self::PASSED, self::FAILED];
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function repaymentDuration()
    {
        return $this->belongsTo(RepaymentDuration::class);
    }

    public function repaymentCycle()
    {
        return $this->belongsTo(RepaymentCycle::class);
    }
    public function downPaymentRate()
    {
        return $this->belongsTo(DownPaymentRate::class, 'down_payment_rate_id');
    }

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class, 'business_type_id');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(NewDocument::class, 'documentable');
    }
}
