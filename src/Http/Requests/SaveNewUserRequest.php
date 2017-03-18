<?php

namespace Inferno\Foundation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SaveNewUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->hasRole('admin')) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users',
            'active' => 'required|boolean',
            'roles' => 'required|array',
            'password' => 'required|min:6|max:16',
            'confirm_password' => 'required|same:password',
        ];
    }
}
