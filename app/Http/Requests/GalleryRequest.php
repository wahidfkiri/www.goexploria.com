<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class GalleryRequest extends Request
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
      $this->request->add( ['user_id' => Auth::user()->id] );

      return [
          'name' => 'required|min:3|max:100',
          'languages' => 'required',
          'locations' => 'required',
          #'country' => 'required',
          #'slug' => 'required|min:3|max:45',
          #'content' => 'required|min:10',
          #'target' => 'max:200',

      ];
    }
}
