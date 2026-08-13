<?php

namespace App\Http\Middleware;

use Closure;
#use Illuminate\Routing\Redirector;

class Locale
{
    /*
    protected $languages = ['en','fr'];
    
    public function __construct(Redirector $redirector) {
        $this->redirector = $redirector;
    }    
    */
        
    public function handle($request, Closure $next)
    {            
      #dd($locale);

      $locale = $request->segment(1);
      
      // Make sure current locale exists.
      if ( array_key_exists($locale, app()->config->get('app.locales'))) 
      {
        app()->setLocale($locale);
        session()->put('locale', $locale);
      } 
      else 
      {          
        session()->put('locale', app()->config->get('app.fallback_locale'));        
        #return redirect('/en');
        #$segments = $request->segments();
        #$segments[0] = app()->config->get('app.fallback_locale');         
        #return $this->redirector->to(implode('/', $segments));
      }
            
      return $next($request);
      
      // Old code        
      #if(!session()->has('locale'))
      #{
      #    session()->put('locale', $request->getPreferredLanguage($this->languages));
      #}

      #app()->setLocale(session()->get('locale'));

      #return $next($request);
    }
}
