<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
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
            "email" => "required|email",
            "password" => "required"
        ];
    }

    public function messages()
    {
        return [
            "email.required" => "Bu alan zorunludur.",
            "email.email" => "Lütfen eposta kurallarına uygun giriş yapınız.",
            "password.required" => "Bu alan zorunludur.",
        ];
    }
}
