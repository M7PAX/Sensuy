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
            'title' => ['required', 'min:5', 'max:100'],
            'description' => ['nullable', 'min:5', 'max:1000'],
            'url' => ['nullable', 'url'],
            'file' => [
                'nullable',
                'file',
                'max:1048576', // 1GB
                'mimetypes:' .
                'image/jpeg,image/png,image/gif,image/webp,' .
                'video/mp4,video/webm,video/ogg,' .
                'audio/mpeg,audio/wav,audio/ogg,audio/aac,audio/mp3,audio/webm'
            ],
            'file_name' => ['nullable', 'string', 'min:5', 'max:50'],
        ];
    }
}
