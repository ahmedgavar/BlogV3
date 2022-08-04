<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostImagesRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'images' => [
                'required',

            ],


            'images.*' =>
            [

                'image',
                'max:2048',

                'mimes:jpeg,png,jpg,gif,svg|',
                'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'

            ]



        ];
    }

    public function messages()
    {
        return [

            'images.required' => "يجب اختبار صورة معبرة",
            'images.max' => "اختر صورة أقل حجما",
            'images.*.image' => 'هذا النوع غير مقبول',
            'images.*.dimensions' => 'هذا المقاس غير مناسب',
            'images.*.mimes' => 'هذا الامتداد غير متاح'

        ];
    }
}
