<?php

declare(strict_types=1);

namespace Modules\Image\Handlers;

use Modules\Image\Commands\ChangeImageOrderCommand;

class ChangeImageOrderHandler
{
    public function handle(ChangeImageOrderCommand $command)
    {
        $image = $command->getImage();

        $images = $image->imageable->images()->select('id', 'order');

        if ($command->order < $image->getOrder()) {
            $images = $images->whereBetween('order', [$command->order, $image->getOrder() - 1]);
        }else{
            $images = $images->whereBetween('order', [$image->getOrder() + 1, $command->order]);
        }

        $images = $images->get();

        foreach ($images as $img) {
            $newOrder = ($command->order > $image->getOrder()) ? $img->getOrder() - 1 : $img->getOrder() + 1;

            $img->setOrder($newOrder)
                ->save();
        }

        $image->setOrder($command->order)
              ->save();
    }
}

