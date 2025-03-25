<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use App\Supports\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $table = 'posts';

    protected $guarded = [];

    protected $columnSlug = 'title';

    protected $casts = [
        'is_featured' => 'boolean',
        'status' => ActiveStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function isFeatured()
    {
        return $this->is_featured == true;
    }

    public function isPublished()
    {
        return $this->status == ActiveStatus::Active->value;
    }

    public function catalogues()
    {
        return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_posts', 'post_id', 'post_catalogue_id');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', ActiveStatus::Active->value);
    }

    public function scopeHasCatalogues($query, array $cataloguesId)
    {
        return $query->whereHas('catalogues', function ($query) use ($cataloguesId) {
            $query->whereIn('id', $cataloguesId);
        });
    }
}