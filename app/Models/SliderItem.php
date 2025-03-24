<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderItem extends Model
{
    use HasFactory;

    protected $table = 'slider_items';

    protected $guarded = [];

    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }
}