<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Activity;
use App\Models\User;
use App\Models\Location;
use App\Models\LocationType;
use App\Models\Company;
use App\Models\Country;
use App\Models\UserType;
use App\Models\Page;
use App\Models\Newsletter;
use App\Models\NewsletterHistory;
use Redirect;
use Mail;

class MainController extends Controller
{
   	
    public function dashboard() {
        $usersActivated = User::where('is_activated', true)->count();
        $usersTypes = UserType::all();
        $usersUnactivated = User::where('is_activated', false)->count();
        $usersRecentlyRegistred = User::where('is_activated', true)->where('created_at', '>=', time() - (24*60*60))->count();
        $countries = Country::where('is_activated', true)->count();
        $locations = Location::where('is_activated', true)->count();
        $companies = Company::count();
        $activities = Activity::count();
        $abonnes = User::where('is_news_enabled', true)->count();
        $newsletterSended = NewsletterHistory::count();
        $sended = NewsletterHistory::select('newsletter_id')->distinct()->pluck('newsletter_id');

        $newsletterNotSended = Newsletter::whereNotIn('id', $sended)->count();
        $locationsPages = Page::join('locations_pages as lp', 'lp.page_id', '=', 'pages.id')->where('is_visible', true)->count();
        $companiesPages = Page::join('companies_pages as cp', 'cp.page_id', '=', 'pages.id')->where('is_visible', true)->count();
        $companiesActivities = Company::join('companies_activities as ca', 'ca.company_id', '=', 'companies.id')->count();

        $visits = Company::getVisits();

        return view('back.index', compact('visits', 'usersActivated', 'usersUnactivated', 'usersTypes', 'usersRecentlyRegistred', 'countries', 'companies', 'locations', 'activities', 'newsletterSended', 'abonnes', 'newsletterNotSended', 'locationsPages', 'companiesPages', 'companiesActivities'));
    }


    public function test() {
        // Envoi du mail
        $toEmail = "demmon.cyril@gmail.com";
        $subject = "Coucou";
        $var = "lel";
        Mail::send ( 'mail', compact('var'), function ($message) use($toEmail, $subject) {
            $message->to ( $toEmail )->subject ( $subject );
        } );
        return Redirect::back();
    }

    public function testback() {
        $villes = Location::where('parent_id', 89)->get();
        return view('back.test', compact('villes'));
    }
}
