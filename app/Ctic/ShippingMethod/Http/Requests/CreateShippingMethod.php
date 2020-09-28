<?php

namespace App\Ctic\ShippingMethod\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Ctic\ShippingMethod\Contracts\Requests\CreateShippingMethod as CreateShippingMethodContract;

class CreateShippingMethod extends FormRequest implements CreateShippingMethodContract
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'name'          => 'required|min:2|max:50',
            'observation'   => 'nullable',
            'gateway'       => 'nullable|min:2|max:50',
            'order'         => 'nullable|max:50',
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
