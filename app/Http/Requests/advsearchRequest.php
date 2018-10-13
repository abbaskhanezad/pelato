<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class advsearchRequest extends FormRequest
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
            'money' => 'numeric|min:1000',
            'time' => 'required',
            'endtime' => 'required',
            'rooz' => 'required',
        ];
    }
    public function attributes()
    {
        return
            [

                'money' => 'مبلغ اجاره',
                'time' => 'ساعت شروع اجاره',
                'time' => 'ساعت پایان اجاره',
                'rooz' => 'روز اجاره',

            ];
    }
}
