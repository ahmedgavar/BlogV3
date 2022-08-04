<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => "يجب ادخال الايميل ",
            'email.exists' => "الايميل غير موجود",
            'email.max' => "ايميل غير صالح",
            'password.string' => "الباسورد يجب أن يكون حروف",
            'password.unique' => "  الباسورد مطلوب  ",
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
