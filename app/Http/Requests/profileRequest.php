<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class profileRequest extends FormRequest
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
            'name' => 'required',
            'family' => 'required',
            'email' => 'email|unique:users,email,' . \Session::get('userid')->id,
            'mobile' => 'required|unique:users,mobile,'. \Session::get('userid')->id,

        ];

    }

    public function attributes()
    {
        return
            [

                'name' => 'نام ',
                'email' => 'ایمیل',
                'mobile' => 'موبایل  ',
                'family' => 'نام خانوادگی  ',


            ];
    }
}
