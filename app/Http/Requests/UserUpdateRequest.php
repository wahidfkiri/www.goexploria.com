<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserUpdateRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [ 
                        'first_name' => 'required|min:2|max:30',
                        'last_name' => 'required|min:2|max:30',
                'ville' => 'numeric',
            'cp' => 'alpha_num|max:20',
            'phone' => 'max:20',
            'fax' => 'max:20',
            'adresse' => 'max: 100',
            'website' => 'active_url|max:100', 
                        
        ];
    }
}
