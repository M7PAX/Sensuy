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
            'content' => 'required|string|max:500|min:1',
        ]);

        $post = Post::where('slug', $post_slug)->firstOrFail();

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('message', __('comment created'));
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
            'content' => 'required|string|max:500|min:1',
        ]);

        $comment->update($validated);

        return redirect()->route('posts', [$community_slug, $post_slug])->with('message', __('comment updated'));
    }

    public function destroy($community_slug, $post_slug, Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return back()->with('message', __('comment deleted'));
    }
}
