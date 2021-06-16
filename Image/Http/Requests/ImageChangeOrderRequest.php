<?php

declare(strict_types=1);

namespace Modules\Image\Http\Requests;

use Modules\Core\Http\Requests\FormRequest;
use Modules\Image\Rules\OrderRule;

class ImageChangeOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order' => ['required', 'integer', new OrderRule($this->image)]
        ];
    }

}
