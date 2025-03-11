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
        $posts = PostResource::collection(Post::with(['user', 'community', 'voted' => function ($query)
        {
            $query->where('user_id', auth()->id());
        }])->withCount('comments')->orderBy('votes', 'desc')->take(10)->get());

        $communities = CommunityResource::collection(Community::withCount('posts')->orderBy('posts_count', 'desc')->take(5)->get());

        return Inertia::render('Home', ['communities' => $communities, 'posts' => $posts]);
    }
}
