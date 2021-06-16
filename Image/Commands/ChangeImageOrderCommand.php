<?php

declare(strict_types=1);

namespace Modules\Image\Commands;

class ChangeImageOrderCommand extends ImageCommand
{
    public int $order;
}
