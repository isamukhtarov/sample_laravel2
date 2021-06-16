<?php

declare(strict_types=1);

namespace Modules\Image\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Support\Arr;
use Modules\Image\Entities\Image;

class ImageAble implements ImageAbleInterface
{
    private ImageManipulatorInterface $imageManipulator;

    public function __construct(ImageManipulatorInterface $imageManipulator)
    {
        $this->imageManipulator = $imageManipulator;
    }

    /**
     * @param Model $model
     * @param mixed $images
     * @param string $diskName
     */
    public function attach(Model $model, $images, string $diskName): void
    {
        if (!isset($model->images)) {
            throw new RelationNotFoundException('Images relation is required for this model');
        }

        $images = Arr::wrap($images);

        $lastImage = $model->images()->orderBy('order', 'DESC')->get()->first();

        $order = !empty($lastImage) ? $lastImage->order + 1 : 1;

        foreach ($images as $image) {
            $this->uploadProcess($model, $image, $diskName, $order);
            $order++;
        }

    }

    private function uploadProcess(Model $model, string $image, string $diskName, int $order): void
    {
        $imgObj = new Image();
        $imageName = $this->imageManipulator->upload($image, $diskName);
        $imgObj->setName($imageName)
               ->setOrder($order);

        $model->images()->create($imgObj->toArray());
    }
}
