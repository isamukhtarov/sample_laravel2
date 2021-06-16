<?php

declare(strict_types=1);

namespace Modules\Image\Entities;

interface HasImageInterface
{
    public function getDiskName(): string;
}
