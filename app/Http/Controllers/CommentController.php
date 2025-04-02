<?php

namespace App\Http\Controllers;

use App\Models\Post;

class CommentController extends Controller
{
    public function store(Post $post)
    {
        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => \request()->input('content'),
        ]);

        return back();
    }
}
