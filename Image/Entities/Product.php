<?php

declare(strict_types=1);

namespace Modules\Image\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Product extends Model implements HasImageInterface
{
    protected $table = 'products';
    protected $guarded = ['id'];

    public function images(): Relation
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getDiskName(): string
    {
        return 'shop';
    }
}
