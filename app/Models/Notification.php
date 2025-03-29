<?php

namespace App\Models;

use App\Enums\Notification\NotificationObj;
use App\Enums\Notification\NotificationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $guarded = [];

    protected $casts = [
        'is_read' => 'boolean',
        'objects' => NotificationObj::class,
        'user_types' => NotificationType::class,
        'admin_types' => NotificationType::class,
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}