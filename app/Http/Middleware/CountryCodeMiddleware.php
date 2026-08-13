<?php

namespace App\Http\Middleware;

use Closure;

use DB;

use PDO;

use App\Models\Country;

class CountryCodeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(is_null($request->route('countryCode')) || !$this->countryCodeExists($request->route('countryCode'))){
            return back();
        }
        return $next($request);
    }

    public function countryCodeExists($countryCode){
        $countries = Country::where('is_activated', true)->get();
        foreach($countries as $country){
            if($country->code == $countryCode){
                return true;
            }
        }
        return false;
    }


}
