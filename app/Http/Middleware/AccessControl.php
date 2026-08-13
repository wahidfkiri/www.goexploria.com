<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use App\Models\Module;
use App\Models\Permission;
use Request;

class AccessControl
{    
    public function handle($request, Closure $next)
    {
        if(!Auth::user()->isAdmin() 
        	&& $this->isProtectedRoute(Request::url()) 
        	&& !$this->isAuthorized(Auth::user()->type, Request::url()))
        {
            return Redirect::route('denied');
        }

        return $next($request);
    }

    /** Renvoi true si la liste est listée dans les modules à protéger */
    private function isProtectedRoute($url) {
    	// On récupère la liste des routes protégées
    	$protectedRoute = Module::all();

    	// On parcourt la liste des routes protégées jusqu'au bout où jusqu'à ce qu'on la trouve
    	$found = false;
    	$i = 0;
    	while($i < count_of($protectedRoute) && !$found) {
    		$found = strpos($url, $protectedRoute[$i]->key.'/mod');
    		$i++;	
    	}
    	return $found;
    }

    /** Regarde si l'utilisateur à le droit d'accéder au module */
    private function isAuthorized($userType, $url) {
      $modules = $userType->modules;

      // Aucun droit sur aucun module
      if (count_of($modules) == 0) {
        return false;
      }

      // On parcourt la liste des modules dispo pour ce type d'utilisateur
      $found = false;
      $module = null;
      $i = 0;
      while($i < count_of($modules) && !$found) {
        $module = $modules[$i];
        $found = strpos($url, $module->key.'/mod');
        $i++; 
      }

      // Aucun droit sur le module
      if (!$found) {
        return false;
      }

      // On regarde s'il a les droits pour l'action demandée
      return $this->isAuthorizedAction( $userType, $url, $module);
    }

    /** Regarde si l'utilisateur a le droit d'effectuer l'action demandée sur l'url */
    private function isAuthorizedAction( $userType, $url, $module) {
    	$permissions = Permission::permissions(); // liste des permissions dispos
    	$authorized = false; // true si autorisé

    	// On parcourt la liste des permissions tant que l'on est pas autorisé
    	$i = 0;
    	while($i < count_of($permissions) && !$authorized) {
    		// On regarde si l'autorisation existe
    		if ($userType->authorized($permissions[$i]->key, $module)) {

    			// On regarde si une des clés de la permission s'applique
    			$j = 0;
    			while($j < count_of($permissions[$i]->value) && !$authorized) {
    				$authorized = strpos($url, $permissions[$i]->value[$j]);
    				$j++;
    			}
    		}
    		$i++;
    	}
    	return $authorized;
    }

}
