<?php

declare(strict_types=1);

namespace Modules\Image\Handlers;

use Modules\Image\Commands\DeleteImageCommand;
use Modules\Image\Service\ImageManipulatorInterface;

class DeleteImageHandler
{
    private ImageManipulatorInterface $imageManipulator;

    public function __construct(ImageManipulatorInterface $imageManipulator)
    {
        $this->imageManipulator = $imageManipulator;
    }

    public function handle(DeleteImageCommand $command)
    {
        $image = $command->getImage();

        $images = $image->imageable->images()->select('id', 'order')->where('order', '>', $image->getOrder())->get();

        $this->imageManipulator->delete($image->getName(), $image->imageable->getDiskName());

        if (!empty($images)) {
            foreach ($images as $img) {
                $img->setOrder($img->getOrder() - 1)->save();
            }
        }

        $image->delete();
    }
}
