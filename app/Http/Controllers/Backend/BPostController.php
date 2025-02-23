<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class BPostController extends Controller
{
    public function create(Community $community)
    {
        return Inertia::render('Communities/Posts/PostCreate', compact('community'));
    }

    public function store(StorePostRequest $request, Community $community)
    {
        $community->posts()->create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
        ]);

        return Redirect::route('frontend.communities.show', $community->slug);
    }

    public function edit(Community $community, Post $post)
    {
        Gate::authorize('update', $post);
        return Inertia::render('Communities/Posts/PostEdit', compact('community', 'post'));
    }

    public function update(StorePostRequest $request, Community $community, Post $post)
    {
        Gate::authorize('update', $post);
        $post->update($request->validated());

        return Redirect::route('frontend.communities.posts.show', [$community->slug, $post->slug]);
    }

    public function destroy(Community $community, Post $post)
    {
        Gate::authorize('delete', $post);
        $post->delete();

        return Redirect::route('frontend.communities.show', $community->slug);
    }
}
