<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use App\Supports\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class PostCatalogue extends Model
{
    use HasFactory, NodeTrait, Sluggable, SoftDeletes;

    protected $table = 'post_catalogues';

    protected $guarded = [];

    protected $casts = [
        'status' => ActiveStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();
    }
    public function isPublished()
    {
        return $this->status == ActiveStatus::Active->value;
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_catalogue_posts', 'post_catalogue_id', 'post_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', ActiveStatus::Active->value);
    }
}
