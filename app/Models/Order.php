<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'new_orders';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function amortizations(): HasMany
    {
        return $this->hasMany(Amortization::class, 'new_order_id');
    }
}
