<?php

namespace Modules\Image\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Image\Entities\Image;

class ImageResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Image $this */
        return [
            'id' => $this->id,
            'type_id' => $this->imageable_id,
            'type' => $this->imageable_type,
            'order' => $this->order,
            'url' => \Storage::disk($this->imageable->getDiskName())->url($this->name)
        ];
    }
}
