<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class Admin
{    
    public function handle($request, Closure $next)
    {
        if(!Auth::user()->isAdmin())
        {
            return Redirect::route('denied');
        }

        return $next($request);
    }
}
