<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CenterFormRequest extends FormRequest
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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'username' => 'required|string|unique:users,username|min:6',
                    'name' => 'required|string',
                    'email' => 'required|email|unique:users,email',
                    'mobile' => 'required|unique:users,mobile|numeric|min:11',
                    'password' => 'required|string|min:6|confirmed',
                    'user_images.*' => 'nullable|image|mimes:png',
                    'center_name' => 'required|string',
                    'center_type' => 'required|exists:center_types,id',
                    'center_attribute.*' => 'required|exists:center_attributes,id',
                    'center_address' => 'required|string',
                    'center_phone' => 'required|numeric|min:8',
                    'center_description' => 'nullable',
                    'center_chairs' => 'nullable|numeric|min:0',
                    'ownership' => 'nullable|in:owner,rent',
                    'center_time_activity' => 'nullable|numeric|min:0',
                    'google_map_lat' =>  ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/','numeric'],
                    'google_map_lon' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/','numeric'],
                    'center_image' => 'nullable|image|mimes:png',
//                    'room_name.*' => 'required|string',
//                    'room_size.*' => 'required|min:0',
//                    'chair_count.*' => 'nullable|min:0|numeric',
//                    'room_price.*' => 'required|min:0|numeric',
//                    'floor_type.*' => 'required|string',
//                    'wall_type.*' => 'nullable|string',
//                    'room_attribute.*' => 'nullable|exists:center_attributes,id',
//                    'room_images.*' =>  'required|image|mimes:png',
                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'user_images.*.required' => 'وارد عکس کارت ملی الزامیست',
            'center_name.required' => 'وارد کردن نام مرکز الزامیست',
            'center_type.required' => 'وارد کردن نوع کاربری مرکز الزامیست',
            'center_type.exists' => 'نوع کاربری انتخاب شده برای مرکز صحیح نمی باشد',
            'center_attribute.*.exists' => 'ویژگی انتخاب شده برای مرکز معتبر نمی باشد',
            'center_attribute.*.required' => 'انتخاب ویژگی برای مرکز الزامیست',
            'center_address.required' => 'وارد کردن آدرس مرکز الزامیست',
            'center_images.required' => 'انتخاب عکس برای مرکز الزامیست',
//            'room_name.*.required' => 'وارد کردن نام اتاق الزامیست',
//            'room_size.*.required' => 'وارد کردن اندازه اتاق الزامیست',
//            'room_price.*.required' => 'وارد کردن هزینه اتاق الزامیست',
//            'floor_type.*.required' => 'وارد کردن جنس کف اتاق الزامیست '
        ];
    }
}
