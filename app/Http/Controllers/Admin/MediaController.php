<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Redirect;

class MediaController extends Controller
{
	//GET ROUTES
    public function getSearch()
    {
        return view('back.media.search');
    }

}
