<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddCountryPostRequest extends Request
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
            'continent' => 'required|numeric|min:0',
            'name' => 'required|min:2',
            'rank' => 'numeric|min:0',
            'code' => 'required|alpha|size:2|unique:countries,code',
        ];
    }
}
