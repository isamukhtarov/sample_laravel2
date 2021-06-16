<?php

declare(strict_types=1);

namespace Modules\Image\Handlers;

use Modules\Image\Commands\CreateImageCommand;
use Modules\Image\Service\ImageAbleInterface;

class CreateImageHandler
{
    private ImageAbleInterface $imageAble;

    public function __construct(ImageAbleInterface $imageAble)
    {
        $this->imageAble = $imageAble;
    }

    public function handle(CreateImageCommand $command)
    {
        $this->imageAble->attach($command->getModel(), $command->image, $command->getModel()->getDiskName());

        $command->imgObj = $command->getModel()->images()->get()->last();
    }
}
