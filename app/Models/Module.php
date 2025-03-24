<?php

namespace App\Models;

use App\Enums\Module\ModuleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';

    protected $guarded = [];

    protected $casts = [
        'status' => ModuleStatus::class,
    ];
}