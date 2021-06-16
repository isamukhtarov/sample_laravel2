<?php

declare(strict_types=1);

namespace Modules\Image\Rules;

use Illuminate\Contracts\Validation\Rule;
use Symfony\Component\HttpFoundation\File\File;

class SizeRule implements Rule
{
    private int $maxSize;
    private int $minSize;

    public function __construct(int $maxSize, int $minSize = 0)
    {
        $this->maxSize = $maxSize;
        $this->minSize = $minSize;
    }

    public function passes($attribute, $value): bool
    {
        if($this->getFileSize($value) > $this->maxSize || ($this->minSize && $this->getFileSize($value) < $this->minSize))
            return false;

        return true;
    }

    public function message(): string
    {
        $message = "Image size must be not over than {$this->maxSize}";

        if ($this->minSize)
            $message .= " and not less than {$this->minSize}";

        return $message;
    }

    /**
     * @param string $value
     * @return File
     */
    protected function convertToFile(string $value): File
    {
        $binaryData = base64_decode($value);
        $tmpFile = tempnam(sys_get_temp_dir(), 'base64validator');
        file_put_contents($tmpFile, $binaryData);

        return new File($tmpFile);
    }

    protected function getFileSize(string $value): int
    {
        return $this->convertToFile($value)->getSize();
    }
}
