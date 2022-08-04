<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
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
        $rules = [

            'title' => [
                'required',
                'string',
                'min:15',
                'max:25',

            ],

            'content' => [
                'required',
                'min:25',

            ],
            'user_id' => [
                'required',
                'exists:users,id',

            ],

            //
        ];

        return $rules + ($this->isMethod('POST') ? $this->store() : $this->update());
    }
    protected function store()
    {
        return ['title' => 'unique:posts,title'];

    }
    protected function update()
    {
        return [
            'title' => Rule::unique('posts', 'title')->ignore($this->post),
            //… more validation

        ];
    }
    public function messages()
    {
        return [
            'title.required' => "أدخل عنوان المقال ",
            'title.min' => "عنوان المقال قصير جدا ",
            'title.max' => "عنوان المقال طويل جدا",
            'title.string' => "عنوان المقال  غير مناسب",
            'title.unique' => " هذا العنوان مكرر    ",

            'content.required' => "يجب ادخال محتوي",
            'content.min' => "المقال قصير جدا",

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => 'false',
            'message' => $validator->messages()->first(),
            'data' => null,
        ], 422));
    }
}
