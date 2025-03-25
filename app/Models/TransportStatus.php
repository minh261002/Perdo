<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Transport\TransportStatus as TransportStatusEnum;

class TransportStatus extends Model
{
    use HasFactory;

    protected $table = 'transport_statuses';

    protected $guarded = [];

    protected $casts = [
        'status' => TransportStatusEnum::class
    ];
}
