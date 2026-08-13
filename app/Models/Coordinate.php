<?php

namespace App\Models;

use App\Models\BaseModel;


class Coordinate extends BaseModel
{
    protected $table = 'coordinates';

    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }

    public function companies()
    {
        return $this->hasMany('App\Models\Company', 'coordinate_id');
    }

    public function locations()
    {
        return $this->hasMany('App\Models\Location', 'coordinate_id');
    }

    public function set($request) {
        $this->fax = $request->fax != null ? $request->fax : null;
        $this->mail = $request->mail != null ? $request->mail : null;
        $this->adresse = $request->adresse != null ? $request->adresse : null;
        $this->tel = $request->tel != null ? $request->tel : null;
        $this->website = $request->website != null ? $request->website : null;
        $this->code_postal = $request->cp != null ? $request->cp : null;
        $this->location_id = $request->ville != null ? $request->ville : null;
        return $this;
    } 
}
