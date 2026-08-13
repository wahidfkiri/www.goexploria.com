<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Lang extends Controller
{
    public function setLang($lang)
    {
    	$languages = ['en','fr']; //TODO MAKE IT GLOBAL
    	if(in_array($lang, $languages)){
	       	session()->put('locale', $lang);
    	}
    	return redirect('/');
    }
    
}
