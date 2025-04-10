<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $guarded = [];


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function statuses()
    {
        return $this->hasMany(OrderStatus::class, 'order_id'); // Quan hệ 1-n
    }

    public function transport()
    {
        return $this->hasOne(Transport::class, 'order_id', 'id');
    }

}