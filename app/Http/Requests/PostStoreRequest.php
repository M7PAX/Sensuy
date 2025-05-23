<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'title' => ['required', 'min:1', 'max:50'],
            'description' => ['nullable', 'max:1000'],
            'url' => ['nullable', 'url'],
            'file' => [
                'nullable',
                'file',
                'max:20480', // 20MB
                'mimetypes:' .
                'image/jpeg,image/png,image/jpg,image/gif,' .
                'video/mp4,video/webm,video/ogg,' .
                'audio/mpeg,audio/wav,audio/ogg,audio/aac,audio/mp3,audio/webm'
            ],
            'file_name' => ['nullable', 'string', 'max:100'],
        ];
    }
}
