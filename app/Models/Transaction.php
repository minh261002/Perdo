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
}