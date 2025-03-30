<?php

namespace App\Models;

use App\Enums\Transaction\PaymentMethod;
use App\Enums\Transaction\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $guarded = [];

    protected $casts = [
        'payment_method' => PaymentMethod::class,
        'payment_status' => PaymentStatus::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
