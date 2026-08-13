<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Auth;

class MediaRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if( Auth::user()->isAdmin() )
          return true;
          
        return false;
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
          'gallery_id' => 'required',
          'name' => 'required|min:3|max:100',          
          'slug' => 'required|min:3|max:45',
          'target' => 'max:200',
          
      ];
    }
}
