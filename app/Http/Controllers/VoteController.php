<?php

namespace App\Http\Controllers;

use App\Events\Votes\DownVoted;
use App\Events\Votes\RemoveVoted;
use App\Events\Votes\UpVoted;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostVotes;

class VoteController extends Controller
{
    public function upVote(Post $post)
    {
        $isVoted = PostVotes::where('post_id', $post->id)->where('user_id', auth()->id())->first();
        if (! is_null($isVoted)) {
            if ($isVoted->vote === -1) {
                $isVoted->update(['vote' => 1]);
                $post->increment('votes', 2);
//                broadcast(new UpVoted(new PostResource($post)));

                return redirect()->back();
            } elseif ($isVoted->vote === 1) {
//                broadcast(new UpVoted(new PostResource($post)));

                return redirect()->back();
            }
        } else {
            PostVotes::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
                'vote' => 1,
            ]);

            $post->increment('votes', 1);
//            broadcast(new UpVoted(new PostResource($post)));

            return redirect()->back();
        }
    }

    public function downVote(Post $post)
    {
        $isVoted = PostVotes::where('post_id', $post->id)->where('user_id', auth()->id())->first();
        if (! is_null($isVoted)) {
            if ($isVoted->vote === 1) {
                $isVoted->update(['vote' => -1]);
                $post->decrement('votes', 2);
//                broadcast(new DownVoted(new PostResource($post)));

                return redirect()->back();
            } elseif ($isVoted->vote === -1) {
//                broadcast(new DownVoted(new PostResource($post)));

                return redirect()->back();
            }
        } else {
            PostVotes::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
                'vote' => -1,
            ]);

            $post->decrement('votes', 1);
//            broadcast(new DownVoted(new PostResource($post)));

            return redirect()->back();
        }
    }

    public function removeVote(Post $post)
    {
        $isVoted = PostVotes::where('post_id', $post->id)->where('user_id', auth()->id())->first();

        if (! is_null($isVoted)) {
            if ($isVoted->vote === 1) {
                $post->decrement('votes', 1);
            } elseif ($isVoted->vote === -1) {
                $post->increment('votes', 1);
            }

            $isVoted->delete();
        }

//        broadcast(new RemoveVoted(new PostResource($post)));

        return redirect()->back();
    }
}
