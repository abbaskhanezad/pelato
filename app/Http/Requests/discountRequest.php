<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class discountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'discounts_name' => 'required|unique:discounts,discounts_name',
            'discounts_value' => 'required|numeric|min:1|max:100',

        ];

    }

    public function attributes()
    {
        return
            [

                'discounts_name' => 'عنوان تخفیف ',
                'discounts_value' => 'میزان تخفیف',

            ];
    }
}
