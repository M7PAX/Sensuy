<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'user_id',
        'community_id',
        'title',
        'slug',
        'description',
        'url',
        'votes'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function voted()
    {
        return $this->hasMany(PostVotes::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }

    protected static function booted()
    {
        static::deleting(function ($post) {
            $post->files->each(function ($file) {
                Storage::delete($file->path);
            });

            $post->files()->delete();
        });
    }
}
