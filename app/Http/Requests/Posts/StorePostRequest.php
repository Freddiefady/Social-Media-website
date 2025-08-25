<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StorePostRequest extends FormRequest
{
    public static array $extensions = [
        'jpg', 'jpeg', 'png', 'gif', 'webp',
        'mp4', 'mov', 'mp3', 'wav',
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv',
        'zip'
    ];

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
            'body' => 'nullable|string|max:5000',
            'attachments' => 'array|max:50',
            'attachments.*' => [
                'file',
                File::types(self::$extensions)->max(500 * 1024 * 1024), // 5MB max
            ],
        ];
    }

    public function messages()
    {
        return [
            'attachments.*' => 'Invalid file',
        ];
    }
}
