<?php

namespace App\Ctic\PaymentMethod\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Ctic\PaymentMethod\Contracts\Requests\UpdatePaymentMethod as UpdatePaymentMethodContract;

class UpdatePaymentMethod extends FormRequest implements UpdatePaymentMethodContract
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
