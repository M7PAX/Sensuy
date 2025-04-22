<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityStoreRequest;
use App\Http\Requests\CommunityUpdateRequest;
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
            'description' => $community->description,
            'picture' => $community->picture,
        ]);

        return Inertia::render('Communities/CommunityIndex', ['communities' => $communities]);
    }

    public function create()
    {
        return Inertia::render('Communities/CommunityCreate');
    }

    public function store(CommunityStoreRequest $request)
    {
        $data = $request->validated() + ['user_id' => Auth::user()->id];
        $community = Community::create($data);

        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('community_pictures', 'public');
            $community->update(['picture' => $picturePath]);
        }

        if ($request->hasFile('background')) {
            $backgroundPath = $request->file('background')->store('community_backgrounds', 'public');
            $community->update(['background' => $backgroundPath]);
        }

        return to_route('communities.index')->with('message', __('community created'));
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

    public function update(CommunityUpdateRequest $request, Community $community)
    {
        Gate::authorize('update', $community);
        $data = $request->validated();
        $community->update($data);

        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('community_pictures', 'public');
            $community->update(['picture' => $picturePath]);
        }

        if ($request->hasFile('background')) {
            $backgroundPath = $request->file('background')->store('community_backgrounds', 'public');
            $community->update(['background' => $backgroundPath]);
        }

        return to_route('communities.index')->with('message', __('community updated'));
    }

    public function destroy(Community $community)
    {
        Gate::authorize('delete', $community);
        $community->delete();

        return back()->with('message', __('community deleted'));
    }
}
