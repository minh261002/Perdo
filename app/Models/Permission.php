<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $guarded = [];

    protected $casts = [];

    /**
     * Xác định mối quan hệ many-to-many với bảng roles.
     *
     * @return BelongsToMany
     */

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions');
    }


    // Định nghĩa mối quan hệ với bảng Module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}