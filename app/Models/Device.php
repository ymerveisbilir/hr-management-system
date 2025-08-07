<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    protected $fillable = [
        'name',
        'type',
        'serial_number',
        'description',
    ];

    public function assignments()
    {
        return $this->hasMany(DeviceAssignment::class);
    }
}
