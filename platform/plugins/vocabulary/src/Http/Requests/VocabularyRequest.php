<?php

namespace Botble\Vocabulary\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class VocabularyRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vocabulary'   => 'required',
            'vietnamese'   => 'required',
            'type' => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
