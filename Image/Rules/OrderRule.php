<?php

declare(strict_types=1);

namespace Modules\Image\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Image\Entities\Image;

class OrderRule implements Rule
{
    private Image $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function passes($attribute, $value): bool
    {
        if (!$this->checkValidOrder($value))
            return false;

        if ($this->image->getOrder() === $value)
            return false;

        return true;
    }

    public function message(): string
    {
        return 'Prevent not existing or image current order value';
    }

    private function checkValidOrder($value): bool
    {
        $images = Image::query()->select('order')
            ->where('imageable_type', '=', $this->image->getImageAbleType())
            ->where('imageable_id', '=', $this->image->getImageAbleId())
            ->get();

        return $images->contains('order', $value);
    }
}
