<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use App\Supports\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'brands';

    protected $guarded = [];

    protected $casts = [
        'show_home' => 'boolean',
        'active' => ActiveStatus::class
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'brand_categories', 'brand_id', 'category_id');
    }

}
