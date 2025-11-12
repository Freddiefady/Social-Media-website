<?php

declare(strict_types=1);

namespace App\Http\Requests\Posts;

use App\Rules\TotalSizeFiles;
use App\Rules\UserExists;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

/**
 * @property string $body
 */
class StorePostRequest extends FormRequest
{
    /**
     * @var array|string[]
     */
    public static array $extensions = [
        'jpg', 'jpeg', 'png', 'gif', 'webp',
        'mp4', 'mov', 'mp3', 'wav',
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv',
        'zip',
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): true
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string', 'max:5000'],
            'attachments' => ['array', 'max:50', new TotalSizeFiles()],
            'attachments.*' => ['file', File::types(...self::$extensions)],
            'group_id' => ['nullable', 'exists:groups,id', new UserExists()],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
           'body' => nl2br($this->body)
        ]);
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'attachments.*.file' => 'Each attachment must be a file.',
            'attachments.*.mimes' => 'Invalid file type for attachment.',
        ];
    }
}
