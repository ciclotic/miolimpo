<?php

namespace App\Ctic\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vanilo\Framework\Contracts\Requests\UpdateProperty as UpdatePropertyContract;

class UpdateGroup extends FormRequest implements UpdatePropertyContract
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'name'          => 'required|min:2|max:50',
            'observation'   => 'nullable|max:50',
            'order'         => 'nullable|max:50',
            'mandatory'     => 'nullable',
            'unique_group'  => 'nullable',
            'collapsed'     => 'nullable',
        ];
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }
}
