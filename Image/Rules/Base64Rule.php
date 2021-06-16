<?php

declare(strict_types=1);

namespace Modules\Image\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64Rule implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (strpos($value, 'data:') === false || strpos($value, ';base64,') === false || strpos($value, 'image/') === false)
            return false;

        return true;
    }

    public function message(): string
    {
        return 'Incorrect format of the image';
    }
}
