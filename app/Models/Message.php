<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'messages';

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public static function getLastMessagesForAdmin($adminId)
    {
        $messages = self::where(function ($query) use ($adminId) {
            $query->where('sender_id', $adminId)
                ->orWhere('receiver_id', $adminId);
        })
            ->orderByDesc('created_at')
            ->get();

        $conversations = [];

        foreach ($messages as $message) {
            $otherAdminId = ($message->sender_id == $adminId) ? $message->receiver_id : $message->sender_id;

            if (!isset($conversations[$otherAdminId])) {
                $conversations[$otherAdminId] = $message;
            }
        }

        return $conversations;
    }

    public function sender()
    {
        return $this->belongsTo(Admin::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Admin::class, 'receiver_id');
    }
}
