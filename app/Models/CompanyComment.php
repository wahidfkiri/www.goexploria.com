<?php

namespace App\Models;

use App\Models\BaseModel;

class CompanyComment extends BaseModel
{
    protected $table = 'companies_comments';

    public $timestamps = false;

    public function company(){
    	return $this->belongsTo('App\Models\Company', 'company_id');
    }
}
