<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'theme' => ['required', 'in:' . implode(',', $this->availableThemes())],
            'language' => ['required', 'in:en, lv, ru'],
        ];
    }

    private function availableThemes(): array
    {
        return [
            'light', 'dark', 'cupcake', 'bumblebee', 'emerald',
            'corporate', 'synthwave', 'retro', 'cyberpunk',
            'valentine', 'halloween', 'garden', 'forest',
            'aqua', 'lofi', 'pastel', 'fantasy', 'wireframe',
            'black', 'luxury', 'dracula', 'cmyk', 'autumn',
            'business', 'acid', 'lemonade', 'night', 'coffee',
            'winter', 'dim', 'nord', 'sunset', 'caramellatte',
            'abyss', 'silk'
        ];
    }
}
