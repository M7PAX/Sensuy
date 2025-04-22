<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'theme' => ['required', 'in:' . implode(',', $this->availableThemes())],
            'language' => ['required', 'in:EN,LV,RU'],
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
