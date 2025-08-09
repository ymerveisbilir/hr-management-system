<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'allowed_extensions',
        'is_active',
    ];

    protected $casts = [
        'allowed_extensions' => 'array',
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
