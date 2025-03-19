<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityStoreRequest;
use App\Http\Resources\PostResource;
use App\Models\Community;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::where('user_id', auth()->id())->paginate(5)->through(fn ($community) => [
            'id' => $community->id,
            'name' => $community->name,
            'slug' => $community->slug,
        ]);

        return Inertia::render('Communities/CommunityIndex', ['communities' => $communities]);
    }

    public function create()
    {
        return Inertia::render('Communities/CommunityCreate');
    }

    public function store(CommunityStoreRequest $request)
    {
        Community::create($request->validated() + ['user_id' => Auth::user()->id]);

        return to_route('communities.index')->with('message', 'Community created successfully!');
    }

    public function show($slug)
    {
        $community = Community::where('slug', $slug)->firstOrFail();

        $posts = PostResource::collection($community->posts()->with([
            'user',
            'voted' => fn($q) => $q->where('user_id', auth()->id()),
            'files'
        ])->withCount('comments')->paginate(10));

        return Inertia::render('Communities/CommunityShow', [
            'community' => $community,
            'posts' => $posts,
        ]);
    }

    public function edit(Community $community)
    {
        Gate::authorize('update', $community);
        return Inertia::render('Communities/CommunityEdit', ['community' => $community]);
    }

    public function update(CommunityStoreRequest $request, Community $community)
    {
        Gate::authorize('update', $community);
        $community->update($request->validated());

        return Inertia::render('Communities/CommunityIndex')->with('message', 'Community updated successfully!');
    }

    public function destroy(Community $community)
    {
        Gate::authorize('delete', $community);
        $community->delete();

        return back()->with('message', 'Community terminated successfully!');
    }
}
