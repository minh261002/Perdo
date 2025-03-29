<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use App\Supports\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory, NodeTrait, Sluggable;

    protected $table = 'categories';

    protected $guarded = [];

    protected $casts = [
        'show_menu' => 'boolean',
        'show_home' => 'boolean',
        'status' => ActiveStatus::class
    ];

    protected static function boot()
    {
        parent::boot();
    }


    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_categories', 'category_id', 'brand_id');
    }

    public function getDescendantsAndSelf()
    {
        $categories = collect([$this]);

        $children = $this->children;
        foreach ($children as $child) {
            $categories = $categories->merge($child->getDescendantsAndSelf());
        }

        return $categories;
    }
}
