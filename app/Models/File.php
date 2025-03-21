<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'mime_type',
        'post_id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }

    public function getMediaTypeAttribute()
    {
        return explode('/', $this->mime_type)[0];
    }

    public function getSizeAttribute()
    {
        return Storage::exists($this->path) ? Storage::size($this->path) : 0;
    }

    public function getFormattedSizeAttribute()
    {
        $bytes = $this->size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    protected static function booted()
    {
        static::deleted(function ($file) {
            Storage::delete($file->path);
        });
    }
}
