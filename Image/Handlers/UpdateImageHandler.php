<?php

declare(strict_types=1);

namespace Modules\Image\Handlers;

use Modules\Image\Commands\UpdateImageCommand;
use Modules\Image\Service\ImageManipulatorInterface;

class UpdateImageHandler
{
    private ImageManipulatorInterface $imageManipulator;

    public function __construct(ImageManipulatorInterface $imageManipulator)
    {
        $this->imageManipulator = $imageManipulator;
    }

    public function handle(UpdateImageCommand $command)
    {
        $image = $command->getImage();

        $this->imageManipulator->delete($image->getName(), $image->getImageAbleType());

        $newImageName = $this->imageManipulator->upload($command->image, $image->getImageAbleType());

        $image->setName($newImageName);
        $image->save();
    }
}
