<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddCompanyPostRequest extends Request
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
            'name' => 'required|min:0',
            'adresse' => 'required|max:100',
            'cp' => 'required|regex:/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/|max:20',   
            'mailNews' => 'required|email|max:100', 
            'phone' => 'max:20',
            'fax' => 'max:20',
            'website' => 'active_url|max:100',
            'mail' => 'email|max:100',
            'user_mail.*' => 'required|email',
            'user_type.*' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'user_mail.*.required' => 'Le champ email du profil utilisateur est obligatoire.'
        ];
    }
}
