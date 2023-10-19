<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $guard = 'customer';
    protected $guarded = [];
    protected $with = ['verification'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id')->latest();
    }

    public function verification()
    {
        return $this->hasOne(Verification::class)->withDefault();
    }

    public function order_requests()
    {
        return $this->hasMany(OrderRequest::class);
    }

    public function creditCheckerVerifications()
    {
        return $this->hasMany(CreditCheckerVerification::class, 'customer_id');
    }

    public function latestCreditCheckerVerifications()
    {
        return $this->hasOne(CreditCheckerVerification::class, 'customer_id')->latestOfMany();
    }

    public function guarantors()
    {
        return $this->hasMany(Guarantor::class, 'customer_id');
    }

}
