<?php

declare(strict_types=1);

namespace Modules\Image\Http\Requests;

use Modules\Core\Http\Requests\FormRequest;
use Modules\Image\Rules\Base64Rule;
use Modules\Image\Rules\ExtensionRule;
use Modules\Image\Rules\SizeRule;

class ImageStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', new Base64Rule, new ExtensionRule(['jpg', 'jpeg', 'png']), new SizeRule(5000000)]
        ];
    }
}
