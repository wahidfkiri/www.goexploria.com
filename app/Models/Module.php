<?php

namespace App\Models;

use App\Models\BaseModel;

class Module extends BaseModel {

    protected $table = 'modules';
    public $timestamps = false;
    
    private static $function = null;


    public function usersTypes(){
        return $this->belongsToMany("App\Models\UserType", 'permissions', 'module_id', 'type_id')->withPivot('key');
    }
     
   

}
