<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditCompanyInfosRequest extends Request
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
            'name' => 'required|min:2|max:100',
            'slug' => 'required|min:2|max:100',
            'mailNews' => 'required|email|max:100',
            'phone' => 'max:20',
            'fax' => 'max:20',
            'website' => 'active_url|max:255',
            'mail' => 'email|max:100',
            'facebook' => 'active_url',
            'twitter' => 'active_url',
            'google_plus' => 'active_url',
            'linkedin' => 'active_url',
            'instragram' => 'active_url',
            'youtube' => 'active_url',
            'pinterest' => 'active_url',
            'reddit' => 'active_url',
        ];
    }
}
