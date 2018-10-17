<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomReserveRequest extends FormRequest
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
            'user_name' => 'required|string',
            'mobile' => 'required|numeric',
            'price' => 'required|numeric|min:0',
            'status_payment' => 'required|exists:status_payments,id'
        ];
    }

    public function attributes()
    {
        return
            [

                'user_name' => 'نام و نام خانوادگی',
                'mobile' => 'موبایل',
                'price' => 'قیمت  ',
                'status_payment' => 'نوع پرداخت',

            ];
    }
}
