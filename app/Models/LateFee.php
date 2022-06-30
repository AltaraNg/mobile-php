<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LateFee extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';

    public function newOrder(){
        $this->belongsTo(NewOrder::class, 'order_id');
    }
}
