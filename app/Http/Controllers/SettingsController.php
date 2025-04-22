<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsUpdateRequest;

class SettingsController extends Controller
{
    public function update(SettingsUpdateRequest $request)
    {
        $validated = $request->validated();

        if (auth()->check()) {
            auth()->user()->update($validated);
            session(['locale' => $validated['language']]);
        }

        return redirect()->back()->with('message', __('settings updated'));
    }
}
