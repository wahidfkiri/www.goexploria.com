<?php

namespace App\Models;

use App\Models\BaseModel;

class CompanyFollower extends BaseModel
{
    protected $table = 'companies_followers';

    public $timestamps = false;

    public $incrementing = false;

    public $primaryKey = ["company_id", "email"];

    public function company(){
        return $this->belongsTo('App\Models\Company', 'company_id');
    }

    /** Renvoi vrai si le membre est abonné à la newsletter */
    public static function isAFollower($company, $mail) {
    	return CompanyFollower::where('company_id', $company)->where('email', $mail)->count() > 0;
    }

}
