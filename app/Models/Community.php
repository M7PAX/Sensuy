<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Community extends Model
{
    use HasFactory, Searchable, Sluggable;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'slug',
        'picture',
        'background',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPictureUrlAttribute()
    {
        return $this->picture ? asset('storage/'.$this->picture) : null;
    }

    public function getBackgroundUrlAttribute()
    {
        return $this->background ? asset('storage/'.$this->background) : null;
    }
}
