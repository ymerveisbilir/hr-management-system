<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPermissionType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->hasMany(UserPermission::class, 'permission_type_id');
    }
}
