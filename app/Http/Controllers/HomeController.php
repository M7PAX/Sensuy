<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommunityResource;
use App\Http\Resources\PostResource;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function home()
    {
        $posts = PostResource::collection(Post::with([
            'user',
            'community',
            'voted' => fn ($q) => $q->where('user_id', auth()->id()),
            'files',
        ])->withCount('comments')->orderByDesc('votes')->paginate(10));

        $communities = CommunityResource::collection(Community::withCount('posts')->orderByDesc('created_at')->take(10)->get());

        return Inertia::render('Home', ['communities' => $communities, 'posts' => $posts]);
    }

    public function sortCommunities(Request $request)
    {
        $sortOption = $request->query('sort', 'New');

        $query = Community::withCount('posts', 'followers');

        switch ($sortOption) {
            case 'n':
                $query->orderBy('created_at', 'desc');
                break;
            case 'o':
                $query->orderBy('created_at', 'asc');
                break;
            case 'mp':
                $query->orderBy('posts_count', 'desc');
                break;
            case 'lp':
                $query->orderBy('posts_count', 'asc');
                break;
            case 'lf':
                $query->orderBy('followers_count', 'asc');
                break;
            default:
                $query->orderBy('followers_count', 'desc');
                break;
        }

        $communities = $query->take(10)->get();

        return response()->json(CommunityResource::collection($communities));
    }

    public function loadPosts(Request $request)
    {
        $sort = $request->input('sort', 'New');
        $page = $request->input('page', 1);

        $query = Post::with([
            'user',
            'community',
            'voted' => fn ($q) => $q->where('user_id', auth()->id()),
            'files',
        ])->withCount('comments');

        switch ($sort) {
            case 'o':
                $query->orderBy('created_at', 'asc');
                break;
            case 'mu':
                $query->orderBy('votes', 'desc');
                break;
            case 'md':
                $query->orderBy('votes', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $posts = $query->paginate(10, ['*'], 'page', $page);

        return response()->json(PostResource::collection($posts));
    }
}
