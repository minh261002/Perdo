<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Order\OrderStatus as OrderStatusEnum;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = 'order_statuses';

    protected $guarded = [];

    protected $casts = [
        'status' => OrderStatusEnum::class
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
