<?php

namespace App\Http\Middleware;

use Closure;

use Redirect;

use App\Models\Company;

class CompanySlugMiddleware
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
        // Découpage du slug
        $slugs = explode("/", $request->slug);
        
        // Regarde si on a le couple (id / nom)
        if(count_of($slugs) != 2){
            return Redirect::route('error'); 
        }
        
        // On regarde si une entreprise correspond aux données du Slug
        $number = Company::where('id', $slugs[0])
                            ->where('slug', $slugs[1])
                            ->count();
       
        return $number == 1 ? $next($request) : Redirect::route('error');                   
        }
    }

