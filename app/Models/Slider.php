<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'sliders';

    protected $guarded = [];

    protected $casts = [
        'status' => ActiveStatus::class
    ];

    public function items()
    {
        return $this->hasMany(SliderItem::class);
    }
}