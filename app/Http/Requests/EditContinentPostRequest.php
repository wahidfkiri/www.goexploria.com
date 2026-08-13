<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Session;

class EditContinentPostRequest extends Request
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
        $id = Session::get('continent-update');
        return [
            'name' => 'required|min:2',
            'rank' => 'required|numeric|min:0',
            'code' => 'required|alpha|size:2|unique:continents,code,' . $id . ',id',
        ];
    }
}
