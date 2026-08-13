<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterPostRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',//|unique:goe_user,u_email',
            'password' => 'required|between:6,20',
            'passwordConfirmation' => 'required|same:password',
            'birthday' => 'required|date_format:d/m/Y',
        ];
    }
}
    