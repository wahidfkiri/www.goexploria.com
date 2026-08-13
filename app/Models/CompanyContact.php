<?php

namespace App\Models;

use App\Models\BaseModel;

class CompanyContact extends BaseModel {

    protected $table = 'companies_contacts';

	public function jobSearch()
	{
		return $this->belongsTo('App\Models\Company', 'companies_id');
	}

	public static function getPrimaryContact($companyId)
	{
		$companyContact = CompanyContact::where('companies_id', '=', $companyId)->where('is_main_contact', true)->first();

		return $companyContact;
	}

}
