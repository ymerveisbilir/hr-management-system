<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'permission_type_id',
        'start_date',
        'end_date',
        'description',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(UserPermissionType::class, 'permission_type_id');
    }

    public function approverUser()
    {
        return $this->belongsTo(User::class, 'approver_user');
    }

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            0 => 'Reddedildi',
            1 => 'Onaylandı',
            2 => 'Beklemede',
            default => 'Bilinmiyor',
        };
    }
}