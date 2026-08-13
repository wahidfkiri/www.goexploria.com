<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LocationContactRequest extends Request
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
            'slug' => 'required|min:2',
            'name' => 'required',
            'population' => 'numeric|min:0',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'superficie' => 'numeric|min:0',
            'website' => 'active_url', 
            'mail' => 'email', 
            'locationType' => 'required',
            'parentID' => 'numeric',
        ];
    }
}
