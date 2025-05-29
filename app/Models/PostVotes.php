<?php

namespace App\Models;

use App\Events\Votes\DownVoted;
use App\Events\Votes\UpVoted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostVotes extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'vote',
    ];

    //    protected $dispatchesEvents = [
    //        'updated' => [UpVoted::class, DownVoted::class]
    //    ];
}
