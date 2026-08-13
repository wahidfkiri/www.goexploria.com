<?php

namespace App\Models;

use App\Models\BaseModel;

class UserType extends BaseModel {

    protected $table = 'users_types';
    public $timestamps = false;

    public function users() {
    	return $this->hasMany('App\Models\User', 'type_id');
    }

  	public function modules(){
    	return $this->belongsToMany("App\Models\Module", 'permissions', 'type_id', 'module_id')->withPivot('key');
  	}

  	public function authorized($key, $module) {
  		return Permission::where('type_id', $this->id)
                        ->where("module_id", $module->id)
                        ->where('key', $key)
                        ->count() == 1;
  	}
}
