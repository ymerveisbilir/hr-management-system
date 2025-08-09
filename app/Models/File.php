<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_path',
        'original_name',
        'extension',
        'mime_type',
        'size',
        'file_type_id',
        'uploaded_by',
        'user_id',
    ];

    public function fileType()
    {
        return $this->belongsTo(FileType::class);
    }
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'file_user');
    }
}
