<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditCompanySettingsRequest extends Request
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
            // 'name' => 'required|min:2|max:45',
            // 'slug' => 'required|min:2|max:45',
            // 'mailNews' => 'required|email|max:100',
            // 'phone' => 'max:20',
            // 'fax' => 'max:20',
            // 'website' => 'active_url|max:100',
            // 'mail' => 'email|max:100',
            'new_domain' => 'active_url|max:100'


        ];
    }
}
