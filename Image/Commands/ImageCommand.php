<?php

declare(strict_types=1);

namespace Modules\Image\Commands;

use Modules\Core\CommandBus\Command;
use Modules\Image\Entities\Image;

class ImageCommand extends Command
{
    private Image $imageObj;

    public function __construct(Image $imageObj)
    {
        $this->imageObj = $imageObj;
    }

    public function getImage(): Image
    {
        return $this->imageObj;
    }
}
