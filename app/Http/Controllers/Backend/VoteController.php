<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostVotes;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function upVote(Post $post)
    {
        $isVoted = PostVotes::where('post_id', $post->id)->where('user_id', auth()->id())->first();
        if (!is_null($isVoted))
        {
            if ($isVoted->vote === -1)
            {
                $isVoted->update(['vote' => 1]);
                $post->increment('votes', 2);
                return redirect()->back();
            }
            elseif ($isVoted->vote === 1)
            {
                return redirect()->back();
            }
        }
        else
        {
            PostVotes::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
                'vote' => 1
            ]);
            $post->increment('votes', 1);
            return redirect()->back();
        }
    }

    public function downVote(Post $post)
    {
        $isVoted = PostVotes::where('post_id', $post->id)->where('user_id', auth()->id())->first();
        if (!is_null($isVoted))
        {
            if ($isVoted->vote === 1)
            {
                $isVoted->update(['vote' => -1]);
                $post->decrement('votes', 2);
                return redirect()->back();
            }
            elseif ($isVoted->vote === -1)
            {
                return redirect()->back();
            }
        }
        else
        {
            PostVotes::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
                'vote' => -1
            ]);
            $post->decrement('votes', 1);
            return redirect()->back();
        }
    }

}
