<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountApplication extends Model
{
    use HasFactory;

    protected $table = 'discount_applications';
    public $timestamps = false;
    protected $guarded = [];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
