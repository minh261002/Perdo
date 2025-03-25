<?php

namespace App\Models;

use App\Enums\Transport\TransportMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $table = 'transports';

    protected $guarded = [];

    protected $casts = [
        'method' => TransportMethod::class
    ];
}
