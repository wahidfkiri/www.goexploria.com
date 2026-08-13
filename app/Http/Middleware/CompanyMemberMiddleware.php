<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use App\Models\Uer;
use App\Models\Company;

class CompanyMemberMiddleware
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
        if(! Auth::user()->isAdmin()
          && !$this->hasAccessToCompany($request->company_id)
        ) {
          return Redirect::route('denied');
        }
        return $next($request);
    }

    private function hasAccessToCompany($company_id) {
      //array of ids
      $companies = array_map( function($el) { return $el['id']; }, Auth::user()->companies()->select('id')->get()->toArray());
      return in_array($company_id, $companies);
    }
}
