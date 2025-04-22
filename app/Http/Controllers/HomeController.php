<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommunityResource;
use App\Http\Resources\PostResource;
use App\Models\Community;
use App\Models\Post;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function home()
    {
        $posts = PostResource::collection(Post::with([
                'user',
                'community',
                'voted' => fn($q) => $q->where('user_id', auth()->id()),
                'files'
            ])->withCount('comments')->orderByDesc('votes')->paginate(10)
        );

        $communities = CommunityResource::collection(Community::withCount('posts')->orderByDesc('posts_count')->take(5)->get());

        return Inertia::render('Home', ['communities' => $communities, 'posts' => $posts]);
    }

    public function loadMore()
    {
        $posts = PostResource::collection(Post::with([
                'user',
                'community',
                'voted' => fn($q) => $q->where('user_id', auth()->id()),
                'files'
            ])->withCount('comments')->orderByDesc('votes')->paginate(10)
        );

        return response()->json($posts);
    }
}
