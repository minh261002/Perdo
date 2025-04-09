<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'admins';

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    public function checkPermissions($permissionsArr)
    {
        foreach ($permissionsArr as $permission) {
            if ($this->can($permission)) {
                return true;
            }
        }
        return false;
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function lastMessageWith($adminId)
    {
        return $this->sentMessages()
            ->where('receiver_id', $adminId)
            ->orWhere('sender_id', $adminId)
            ->orderByDesc('created_at')
            ->first();
    }

    public function getLastMessages()
    {
        $messages = $this->sentMessages()
            ->orWhereIn('receiver_id', $this->receivedMessages->pluck('sender_id'))
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('receiver_id');

        return $messages->map(function ($conversation) {
            return $conversation->first();
        });
    }


    public function getMessagesForAdmin($adminId)
    {
        $admin = Admin::find($adminId);

        $conversations = $admin->getLastMessages();

        return response()->json([
            'conversations' => $conversations
        ]);
    }
}