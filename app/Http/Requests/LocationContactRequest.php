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
            'website' => 'active_url|max:100', 
            'mail' => 'email|max:100', 
            'ville' => 'numeric',
            'cp' => 'alpha_num|max:20',
            'phone' => 'max:20',
            'fax' => 'max:20',
            'adresse' => 'max: 100',
        ];
    }
}
