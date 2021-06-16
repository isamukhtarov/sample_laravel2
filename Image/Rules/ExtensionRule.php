<?php

declare(strict_types=1);

namespace Modules\Image\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExtensionRule implements Rule
{
    private array $extensions;

    public function __construct(array $extensions)
    {
        $this->extensions = $extensions;
    }

    public function passes($attribute, $value): bool
    {
        $base64Arr = explode(';', $value, 2);

        if (count(explode('/', $base64Arr[0], 2)) === 1)
            return false;

        $mime = explode('/', $base64Arr[0], 2)[1];

        if (!in_array($mime, $this->extensions))
            return false;

        return true;
    }

    public function message(): string
    {
        return 'Forbidden extension';
    }
}
