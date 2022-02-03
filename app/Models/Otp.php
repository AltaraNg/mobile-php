<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function isExpired(): bool
    {
        if ($this->expired) {
            return true;
        }
        $generatedTime = $this->generated_at->addMinutes($this->validity);
        if (strtotime($generatedTime) >= strtotime(Carbon::now()->toDateTimeString())) {
            return false;
        }
        $this->expired = true;
        $this->save();
        return true;
    }

}
