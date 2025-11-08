<?php

declare(strict_types=1);

namespace App\Http\Requests\Posts;

use App\Rules\UserExists;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\File;

final class StorePostRequest extends FormRequest
{
    public static array $extensions = [
        'jpg', 'jpeg', 'png', 'gif', 'webp',
        'mp4', 'mov', 'mp3', 'wav',
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv',
        'zip',
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string', 'max:5000'],
            'attachments' => [
                'array',
                'max:50',
                function ($attribute, $value, $fail): void {
                    // custom rules to check the total size of all files
                    $totalSize = collect($value)->sum(fn (UploadedFile $file) => $file->getSize());

                    if ($totalSize > 1024 * 1024 * 1024) {
                        $fail('The total size of all files must not exceed 1GB.');
                    }
                },
            ],
            'attachments.*' => [
                'file',
                File::types(self::$extensions),
            ],
            'group_id' => ['nullable', 'exists:groups,id', new UserExists()],
        ];
    }

    public function messages(): array
    {
        return [
            'attachments.*.file' => 'Each attachment must be a file.',
            'attachments.*.mimes' => 'Invalid file type for attachment.',
        ];
    }
}
