<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function update(SettingsUpdateRequest $request)
    {
        $validated = $request->validated();

        if (auth()->check()) {
            auth()->user()->update($validated);
            session(['locale' => $validated['language']]);
        }

        return redirect()->back()->with('success', 'Settings updated');
    }
}
