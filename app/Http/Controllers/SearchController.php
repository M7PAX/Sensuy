<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommunityResource;
use App\Http\Resources\PostResource;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json(['error' => 'Search query cannot be empty.'], 400);
        }

        $limit = $request->input('limit', 10);

        $posts = Post::search($query)->take($limit)->get();
        $formattedPosts = PostResource::collection($posts);

        $communities = Community::search($query)->take($limit)->get();
        $formattedCommunities = CommunityResource::collection($communities);

        $results = $formattedPosts->merge($formattedCommunities);

        return response()->json($results);
    }
}
