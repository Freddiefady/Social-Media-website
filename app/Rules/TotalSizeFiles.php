<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\PotentiallyTranslatedString;

final readonly class TotalSizeFiles implements ValidationRule
{
    public function __construct(
        private int $maxSizeInMB = 1024
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // custom rules to check the total size of all files
        if (! is_array($value)) {
            return;
        }

        $totalSize = $this->calculateTotalSize($value);
        $maxSizeInBytes = $this->maxSizeInMB * 1024 * 1024;

        if ($totalSize > $maxSizeInBytes) {
            $fail('The total size of all files must not exceed 1GB.');
        }
    }

    /**
     * Calculate total size of uploaded files
     *
     * @param  array<(string|int),mixed>  $files
     * @return int Total size in bytes
     */
    private function calculateTotalSize(array $files): int
    {
        $totalSize = 0;

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $totalSize += $file->getSize();
            }
        }

        return $totalSize;
    }
}
