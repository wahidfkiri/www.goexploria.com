<?php

namespace App\Models;

use App\Models\BaseModel;

class CompanyMeeting extends BaseModel
{
    protected $table = 'companies_meetings';

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->user_id) && auth()->check()) {
                $model->user_id = auth()->id();
            }
        });
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
