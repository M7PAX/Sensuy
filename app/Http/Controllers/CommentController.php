<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function store(Request $request, $community_slug, $post_slug)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000|min:5',
        ]);

        $community = Community::where('slug', $community_slug)->firstOrFail();

        $post = Post::where('slug', $post_slug)
            ->where('community_id', $community->id)
            ->firstOrFail();

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back();
    }

    public function edit(Community $community, Post $post, Comment $comment)
    {
        Gate::authorize('update', $comment);
        return Inertia::render('Comments/CommentEdit', ['community' => $community, 'post' => $post, 'comment' => $comment]);
    }

    public function update(Request $request, $community_slug, $post_slug, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|max:1000|min:5',
        ]);

        $comment->update($validated);

        return redirect()->route('posts', [$community_slug, $post_slug]);
    }

    public function destroy($community_slug, $post_slug, Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return back();
    }
}
