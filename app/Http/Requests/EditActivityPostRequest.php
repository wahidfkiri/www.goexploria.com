<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditActivityPostRequest extends Request
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
            'name' => 'required|min:2',
            'slug' => 'required|min:2',
            'category_id' => 'required|numeric|min:0'
        ];
    }
}
