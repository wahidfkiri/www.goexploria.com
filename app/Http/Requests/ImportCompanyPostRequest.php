<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ImportCompanyPostRequest extends Request
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
        	'upload' => 'required|file',
            'ville' => 'required|numeric|min:0',
        ];
    }

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
	    return [
	        'upload.required' => 'Le champ fichier XML est obligatoire.'
	    ];
	}
}
