<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommunityPostResource;
use App\Http\Resources\CommunityResource;
use App\Models\Community;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FCommunityController extends Controller
{
    public function show($slug)
    {
        $community = Community::where('slug', $slug)->firstOrFail();
        $posts = CommunityPostResource::collection($community->posts()->with(['user', 'voted' => function ($query)
        {
            $query->where('user_id', auth()->id());
        }])->withCount('comments')->paginate(10));

//        $communities = CommunityResource::collection(Community::withCount('posts')->latest()->take(5)->get());

        return Inertia::render('Frontend/Communities/Show', compact('community', 'posts'));
    }

}
