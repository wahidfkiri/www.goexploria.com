<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use Route;

#use App\Models\ActivityCategory;
#use App\Models\Activity;
use App\Models\Company;

class SiteNavComposer {

    protected $company;
    

    /**
     * Bind data to the view.
     *
     * @param  View  $view 
     * @return void
     */
    public function compose(View $view) {
      
      // Seulement disponible lorsque le site est visité depuis un domaine externe
      $slug = Route::current()->parameter('company_slug');
      
      // DEBUG
      #dd($slug);
      if( isset($slug) ){
          $this->company = Company::getFromSlug($slug);          
          $view->with([
            'company' => $this->company
          ]);
      }
    }
}
