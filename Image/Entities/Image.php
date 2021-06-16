<?php

namespace Modules\Image\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property int id
 * @property int imageable_id
 * @property string imageable_type
 * @property string name
 * @property int order
 * @property Relation imageable
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 */
class Image extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function imageable(): Relation
    {
        return $this->morphTo();
    }

    public function setName(string $name): self
    {
        $this->attributes['name'] = $name;
        return $this;
    }

    public function setOrder(int $order): self
    {
        $this->attributes['order'] = $order;
        return $this;
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getImageAbleType(): string
    {
        return $this->attributes['imageable_type'];
    }

    public function getImageAbleId(): int
    {
        return $this->attributes['imageable_id'];
    }

    public function getOrder(): int
    {
        return $this->attributes['order'];
    }
}
