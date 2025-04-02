<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\PostResource;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PostController extends Controller
{
    public function show($community_slug, $slug)
    {
        $community = Community::where('slug', $community_slug)->first();

        $community_post = Post::with([
            'comments',
            'voted' => fn($q) => $q->where('user_id', auth()->id()),
            'files',
            'user'
        ])->where('slug', $slug)->first();

        $post = new PostResource($community_post);

        $can_update = Auth::check() ? Auth::user()->can('update', $community_post) : false;
        $can_delete = Auth::check() ? Auth::user()->can('delete', $community_post) : false;

        return Inertia::render('Posts/PostShow', [
            'community' => $community,
            'post' => $post,
            'can_update' => $can_update,
            'can_delete' => $can_delete,
        ]);
    }

    public function create(Community $community)
    {
        return Inertia::render('Posts/PostCreate', ['community' => $community]);
    }

    public function store(PostStoreRequest $request, Community $community)
    {
        $post = $community->posts()->create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $directory = match($file->getMimeType()[0]) {
                'i' => 'images',
                'v' => 'videos',
                'a' => 'audio'
            };

            $path = $file->store("public/uploads/{$directory}");

            $post->files()->create([
//                'name' => $name,
                'path' => $path,
                'mime_type' => $file->getClientMimeType(),
            ]);
        }

        return Redirect::route('communities', $community->slug);
    }

    public function edit(Community $community, Post $post)
    {
        Gate::authorize('update', $post);
        return Inertia::render('Posts/PostEdit', ['community' => $community, 'post' => $post]);
    }

    public function update(PostStoreRequest $request, Community $community, Post $post)
    {
        Gate::authorize('update', $post);
        $post->update($request->validated());

        return Redirect::route('posts', [$community->slug, $post->slug]);
    }

    public function destroy(Community $community, Post $post)
    {
        Gate::authorize('delete', $post);
        $post->delete();

        return Redirect::route('communities', $community->slug);
    }
}
