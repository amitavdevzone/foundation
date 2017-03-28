<?php

namespace Inferno\Foundation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required|min:6|max:255',
            'password' => 'required|min:6|max:255',
            'confirm_password' => 'required|same:password',
            'email' => 'required|email'
        ];
    }

    public function messages()
    {
        return [
            'confirm_password.same' => 'Both the password are not same.'
        ];
    }
}
