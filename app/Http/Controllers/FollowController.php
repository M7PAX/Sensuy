<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Community;
use Inertia\Inertia;

class FollowController extends Controller
{
    public function follow(Request $request, Community $community)
    {
        $user = $request->user();

        if ($user->communities()->where('community_id', $community->id)->exists()) {
            return back()->with('error', 'You are already following this community.');
        }

        $user->communities()->attach($community->id);

        return back()->with('success', 'You are now following this community.');
    }

    public function unfollow(Request $request, Community $community)
    {
        $user = $request->user();

        if (!$user->communities()->where('community_id', $community->id)->exists()) {
            return back()->with('error', 'You are not following this community.');
        }

        $user->communities()->detach($community->id);

        return back()->with('success', 'You have unfollowed this community.');
    }
}
