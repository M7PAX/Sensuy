<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\CommunityResource;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $posts = PostResource::collection(Post::with(['user', 'community', 'voted' => function ($query)
        {
            $query->where('user_id', auth()->id());
        }])->withCount('comments')->orderBy('votes', 'desc')->take(10)->get());

        $communities = CommunityResource::collection(Community::withCount('posts')->orderBy('posts_count', 'desc')->take(5)->get());

        return Inertia::render('Welcome', compact('posts', 'communities'));
    }
}
