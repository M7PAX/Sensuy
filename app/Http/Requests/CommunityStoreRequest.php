<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommunityStoreRequest extends FormRequest
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
            'name' => ['required', 'unique:communities', 'min:2', 'max:25'],
            'description' => ['string', 'min:5', 'max:500'],
            'picture' => ['nullable', 'image', 'max:20480'],
            'background' => ['nullable', 'image', 'max:20480'],
        ];
    }
}
