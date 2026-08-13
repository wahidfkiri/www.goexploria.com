<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddLocationPostRequest extends Request
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
            'locationType' => 'required',
            'parentID' => 'numeric',
            'name' => 'required',
            'population' => 'numeric|min:0',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'superficie' => 'numeric|min:0',
            
        ];
    }
}
