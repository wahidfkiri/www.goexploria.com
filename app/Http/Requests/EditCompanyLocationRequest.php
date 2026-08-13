<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditCompanyLocationRequest extends Request
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
            'ville' => 'required|numeric|min:0',    
            'adresse' => 'required|max:100',
            'cp' => 'required|alpha_num|max:20',       
        ];
    }
}
