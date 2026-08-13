<?php

namespace App\Http\Middleware;

use Closure;

use Redirect;

use App\Models\Location;

use App\Models\LocationType;

use App\Models\Continent;

use App\Models\Country;

class LocationSlugMiddleware
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
        
        // Regarde si on a au moins un slug ou si le continent est invalide
        if(count_of($slugs) < 1 || Continent::where('code', '=', $slugs[0])->first() == null){
            return Redirect::route('error'); 
        }
            
        // Si seulement le continent on peut renvoyer
        if(count_of($slugs) == 1){
            $request->route()->setParameter('slug', $slugs[0]);
            $request->route()->setParameter('type', '1');
            return $next($request);                
        }
           
        // On récupère le pays 
        $country = Country::where('slug', $slugs[1])->first();
        if($country == NULL){   // si pays est invalide on sort
            return Redirect::route('error'); 
        }
            
        // Si on a demandé un pays on renvoie
        if(count_of($slugs) == 2){
            $request->route()->setParameter('slug', $request->slug);
            $request->route()->setParameter('type', '2');
            return $next($request); 
        }
          
        // Récupération du premier slug fils
        $location = Location::join('locations_types', 'locations_types.id', '=', 'locations.type_id')
                            ->where('locations_types.parent_id', NULL)
                            ->where('locations.is_activated', true)
                            ->where('locations_types.country_id', $country->id)
                            ->where('locations.slug', $slugs[2])
                            ->select('locations.*')
                            ->first();
                            
        $i = 3; // continent -> pays -> request
        
        // On parcourt l'ensemble du slug
        while($i != count_of($slugs) && $location != NULL){
            // on avance d'un élément dans la hiérarchie
            $location = Location::where('slug', $slugs[$i])->where('parent_id', $location->id)->where('locations.is_activated', true)->first();
            $i++;
        }

        // On est arrivé sur l'élément demandé sans problème -> OK
        if($i == count_of($slugs) && $location != NULL){
            $request->route()->setParameter('type', '3');
            return $next($request); 
        }
                            
        // default : 404
        return Redirect::route('error');                    
    }
}

