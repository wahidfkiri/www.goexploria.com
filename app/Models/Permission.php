<?php

namespace App\Models;

use App\Models\BaseModel;

class Permission extends BaseModel {

    protected $table = 'permissions';

        private static $permissions = null;

  	public function module(){
    	return $this->belongsTo('App\Models\Module', 'module_id');
  	}

  	public function userType(){
    	return $this->belongsTo('App\Models\UserType', 'type_id');
  	}


    /** Renvoi la fonctionnalité concerné */
    public static function   permission($val) {
        if (array_key_exists ( $val, Permission::permissions() )) {
            return self::$permissions [$val];
        } else {
            return self::$permissions [0];
        }
    }

    public static function permissions() {
        self::$permissions = array (
                        0 => (object) ['name' => "Consultation", 'key' => 'read', 'value' => ['search', 'map', 'index', 'details', 'preview', 'get']],
                        1 => (object) ['name' => "Ajout", 'key' => 'add', 'value' => ['add']],
                        2 => (object) ['name' => "Edition", 'key' => 'edit', 'value' => ['edit', 'enable', 'disable', 'send']],
                        3 => (object) ['name' => "Suppression", 'key' => 'delete', 'value' => ['delete']],
        );
        return self::$permissions;
    }

    public static function permissionsList() {
        $return = array();
        foreach (Permission::permissions() as $value) {
            $return[$value->key] = $value->name;
        }
        return $return;
    }


}
