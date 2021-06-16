<?php

declare(strict_types=1);

namespace Modules\Image\Commands;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\CommandBus\Command;
use Modules\Image\Entities\Image;

class CreateImageCommand extends Command
{
    public string $image;

    public Image $imgObj;

    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
