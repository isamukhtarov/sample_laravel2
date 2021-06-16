<?php

declare(strict_types=1);

namespace Modules\Image\Service;

use Illuminate\Database\Eloquent\Model;

interface ImageAbleInterface
{
    /**
     * @param Model $model
     * @param mixed $images
     * @param string $diskName
     */
    public function attach(Model $model, $images, string $diskName): void;
}
