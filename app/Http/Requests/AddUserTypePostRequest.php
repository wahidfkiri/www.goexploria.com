<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddUserTypePostRequest extends Request
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
            "slug" => 'required|min:2|max:45|unique:users_types,slug',
            "content" => 'required|min:10|max:255',
            "name" => 'required|min:2|max:45'
        ];
    }
}
