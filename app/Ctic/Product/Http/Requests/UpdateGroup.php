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
            'product_id'    => 'nullable',
            'mandatory'     => 'nullable|boolean',
            'unique_group'  => 'nullable|boolean',
            'collapsed'     => 'nullable|boolean',
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
