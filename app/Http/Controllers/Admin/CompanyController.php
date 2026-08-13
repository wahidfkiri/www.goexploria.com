<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Page;
use Illuminate\Http\Request;

use App\Http\Requests;
use Redirect;

use App\Models\Company;
use App\Models\Site;
use App\Models\Coordinate;
use App\Models\SocialNetworks;
#use App\Models\Country;
use App\Models\User;

use App\Models\CompanyActivity;

use App\Models\CompanyUser;
use App\Models\UserType;

use App\Models\Location;

use App\Models\LocationType;
use Session;
use App\Models\Activity;
use App\Models\CompanyFollower;
use App\Http\Requests\AddCompanyPostRequest;
use App\Http\Requests\EditCompanyInfosRequest;
use App\Http\Requests\EditCompanySettingsRequest;
use App\Http\Requests\EditCompanyLocationRequest;
use App\Http\Requests\ImportCompanyPostRequest;

use Image;
use App\Helpers\Importer;
use Hash;
use Mail;

class CompanyController extends Controller
{

    // Page de recherche des compagnies
    public function index() {



        // $search n'est affecté que dans la branche « recherche enregistrée » ;
        // compact() lève une ErrorException sur une variable non définie
        // depuis PHP 8 (elle était silencieusement ignorée avant PHP 7.3).
        $search = null;

        // Recherche d'une entreprise dans le cas normal
        if( !Session::has('search-company-data') ){

            // on cherche
            $companies = Company::orderBy('companies.name')
              ->paginate($this->page);

        } else {
            // recherche dans le cas où l'on a déjà des données enregistrés dans le formulaire
            $request = Session::get('search-company-data');
            $search = $request;

            $companies = Company::search($request->name, $request->country, $request->location, $request->activities, $request->mail, $request->tel)
              ->paginate($this->page);
            Session::reflash('search-company-data');

        }

        // On stocke la page courante
        $this->storePage();

        return view ( 'back.company.search', compact('companies', 'search'));
    }


    // Page de recherche des companies
    public function search(Request $request) {
        $data = (object) [
         'name' => $request->name,
         'location' => $request->location,
         'activities' => $request->activities,
         'tel' => $request->tel,
         'mail' => $request->mail,
         'country' => $request->country,
        ];
        Session::flash('search-company-data', $data);

        return Redirect::route('company.search');
    }

    // Suppression des paramètres de recherche
    public function clear() {
        if (Session::has('search-company-data')) {
            Session::forget('search-company-data');
        }

        return Redirect::route('company.search');
    }

    public function add()
    {
        $activities = Activity::pluck('name', 'id')->all();
        $types = UserType::orderBy('name')->pluck('name', 'id');
        $typesDetails = UserType::select('id', 'libelle')->get();
        $languages = Page::languages();

        return view ( 'back.company.add' , compact('activities', 'types', 'typesDetails', 'languages'));
    }

    public function edit($id)
    {
        $company = Company::find($id);
        $activities = $company->activitiesDetails();

        $company_logo = $company->getLogoFilename();
        $company_headImage = $company->getLogoFilename('headImage');
        $company_footerImage = $company->getLogoFilename('footerImage');
        $languages = Page::languages();

        return view ( 'back.company.details' , compact('company', 'activities', 'company_logo', 'company_headImage', 'company_footerImage', 'languages'));
    }

    public function editInfos($id) {
        $company = Company::find($id);

        if(!isset($company->socialNetworks)) {
            $company->socialNetworks()->save(new SocialNetworks());
            $company = Company::find($id);
        }

        $company_list_image = $company->getListImageFilename();
        $languages = Page::languages();

        $pictos = [];
        if (!empty($company->pictos)) {
            $pictos = json_decode($company->pictos, true);
        }


        return view ( 'back.company.information' , compact('company', 'company_list_image', 'languages', 'pictos'));
    }

    public function editAchats($id) {
        $company = Company::find($id);

        $achats = [];
        if (!empty($company->products)) {
            $achats = json_decode($company->products, true);
        }


        return view ( 'back.company.achats' , compact('company', 'achats'));
    }

    public function editLocation($id) {
        $company = Company::find($id);
        return view ( 'back.company.location' , compact('company'));
    }

    public function editActivities($id) {
        $company = Company::find($id);
        $activities = Activity::pluck('name', 'id')->all();
        return view ( 'back.company.activity' , compact('activities', 'company'));
    }

    /** Mise à jour des informations */
    public function updateInfosActivation(Request $request, $id)
    {

        $company = Company::find($id);

        if ($company->is_deactivated) {
            $company->is_deactivated = false;
        } else {
            $company->is_deactivated = true;
        }

        $company->deactivated_date = date('Y-m-d');

        $company->save ();

        return Redirect::route ( 'company.edit.infos', $id)->with ( 'success', "Les informations ont été modifiée avec succès");
    }

    /** Mise à jour des informations */
    public function updateInfos(EditCompanyInfosRequest $request, $id)
    {

        $company = Company::find($id);
        $nom = explode(',', $request->name);
        $company->name = $nom[0];
        $company->slug = $this->generateSlug($request->slug);
        $company->mail_news = $request->mailNews;
        $company->rs_position = $request->rs_position;
        $company->gallery_home = $request->gallery_home;
        $company->newsletter = $request->newsletter;
        $company->slideshow_height = $request->slideshow_height;
        $company->footer_text_color = $request->footer_text_color;
        $company->home_content = $request->home_content;
        $company->logo_gallery_checkbox = ($request->logo_gallery_checkbox == 'on') ? true : false ;
        $company->menu_bg = $request->menu_bg;
        $company->menu_color = $request->menu_color;
        $company->list_image_title = $request->list_image_title;
        $company->list_image_link = $request->list_image_link;
        $company->default_language = $request->default_language;

        $pictosJson = '{}';
        if ($request->pictos) {
            //dd($request->pictos);
            $newPictosArray = [];
            foreach ($request->pictos as $picto) {
                //dd($picto);
                $imageName = (isset($picto['oldimage']) && !empty($picto['oldimage'])) ? $picto['oldimage'] : '' ;
                if (!empty($picto['image'])) {
                    $imageName = $picto['image']->getClientOriginalName();
                    $picto['image']->move('uploads/pictos', $imageName);
                }
                $newPictosArray[] = [
                    'name' => $picto['name'],
                    'url' => $picto['url'],
                    'image' => $imageName,
                ];
            }
            $pictosJson = json_encode($newPictosArray);
        }
        $company->pictos = $pictosJson;

        $company->save ();

        // On met à jour les coordonnées
        $coordinate = Coordinate::find($company->coordinate_id);
        $coordinate->fax = $request->fax != null ? $request->fax : null;
        $coordinate->mail = $request->mail != null ? $request->mail : null;
        $coordinate->tel = $request->tel != null ? $request->tel : null;
        $coordinate->website = $request->website != null ? $request->website : null;
        $coordinate->save();

        $sn = $company->socialNetworks;
        $sn->facebook = $request->facebook != null ? $request->facebook : null;
        $sn->twitter = $request->twitter != null ? $request->twitter : null;
        $sn->google_plus = $request->google_plus != null ? $request->google_plus : null;
        $sn->linkedin = $request->linkedin != null ? $request->linkedin : null;
        $sn->instagram = $request->instagram != null ? $request->instagram : null;
        $sn->youtube = $request->youtube != null ? $request->youtube : null;
        $sn->pinterest = $request->pinterest != null ? $request->pinterest : null;
        $sn->reddit = $request->reddit != null ? $request->reddit : null;
        $sn->save();

        return Redirect::route ( 'company.edit.infos', $id)->with ( 'success', "Les informations ont été modifiée avec succès");
    }

    /** Mise à jour des informations */
    public function updateAchats(Request $request, $id)
    {
        $company = Company::find($id);

        $achatsJson = '{}';
        if ($request->achats) {
            $newAchatsArray = [];
            foreach ($request->achats as $achat) {

                $imageName = (isset($achat['oldimage']) && !empty($achat['oldimage'])) ? $achat['oldimage'] : '' ;
                if (!empty($achat['image'])) {
                    $imageName = $achat['image']->getClientOriginalName();
                    $achat['image']->move('uploads/achats', $imageName);
                }

                $newAchatsArray[] = [
                    'name' => $achat['name'],
                    'price' => $achat['price'],
                    'image' => $imageName,
                    'order' => $achat['order'],
                    'url' => $achat['url'],
                ];
            }
            $achatsJson = json_encode($newAchatsArray);
        }
        $company->products = $achatsJson;


        $company->hide_facturation = ($request->hide_facturation == 'hide') ? true : false;
        $company->achats_no_tps = $request->achats_no_tps;
        $company->achats_no_tvq = $request->achats_no_tvq;
        $company->achats_neq = $request->achats_neq;
        $company->achats_succursale = $request->achats_succursale;
        $company->achats_transit = $request->achats_transit;
        $company->achats_compte = $request->achats_compte;
        $company->achats_payment_button = $request->achats_payment_button;
        $company->achats_note = $request->achats_note;
        $company->achats_frais_transport = $request->achats_frais_transport;
        $company->achats_frais_admin = $request->achats_frais_admin;
        $company->achats_reduction = $request->achats_reduction;
        $company->achats_marche_a_suivre = $request->achats_marche_a_suivre;
        $company->achats_instructions = $request->achats_instructions;
        $company->achats_cheque = $request->achats_cheque;
        $company->versements = $request->versements;

        $company->save ();

        return Redirect::route ( 'company.edit.achats', $id)->with ( 'success', "Les informations ont été modifiée avec succès");
    }

    public function editSettings($id) {
      $company = Company::find($id);
      $configs = Site::where('company_id', $company->id)->pluck('value', 'config');
      $themes = Site::getAvailableThemes();
      $cssFiles = Site::getAvailableCssFiles();
      $curr_theme = $company->getSiteTheme();
      return view ( 'back.company.settings' , compact('company','configs', 'themes', 'curr_theme', "cssFiles"));
    }


    public function updateSettingsAjax(EditCompanySettingsRequest $request, $id) {
      $company = Company::find($id);
      if($request->new_domain) {
        $dom = preg_replace("/http:\/\//", "", $request->new_domain);
        $dom = preg_replace("/www\./", "", $dom);
        if($company->addExternalSite($dom)) {
          return "OK";
        } else {
          return "Error";
        }


      } else if($request->remove_domain) {
        if($company->delExternalSite($request->remove_domain)) {
          return "OK";
        } else {
          return "Error";
        }

      } else if ($request->new_fileCss) {
        $message = "";
        $action = ($request->new_fileCss == 'aucun' ? 'remove' : 'add');
        if($company->add_rm_fileCss($request->new_fileCss, $action, $message)) {
          return response("OK", 200);
        } else {
          return response($message, 406);
        }

      } else if($request->cloneTheme) {
        $themes = Site::getAvailableThemes();
        $theme_parent = $request->cloneTheme["theme_parent"];
        $theme_name = $request->cloneTheme["theme_name"];
        $message = "";
        if (! in_array( $theme_parent, $themes, true)) {
          $message = "Theme parent Not Found";
          return response($message, 406)
                 ->header('Content-Type', 'text/plain');
        }

        if( ! (gettype($theme_name) == "string" && strlen($theme_name) > 1 && strlen($theme_name) < 50) ) {
          $message = "Bad theme name";
          return response($message, 400)
                 ->header('Content-Type', 'text/plain');
        }
        try {
          $res = Site::cloneSiteTheme($theme_parent, $theme_name);
        } catch(Exception $e) {
          $message = $e->getMessage();
          return response($message, 500)
          ->header('Content-Type', 'text/plain');
        }

        $company->setSiteTheme($theme_name);

        return response("OK", 200);

      } else if( $request->selectTheme ) {
          $theme = $request->selectTheme;
          if(gettype($theme) != "string") {
            return response($message, 400)
                   ->header('Content-Type', 'text/plain');
          }
          $company->setSiteTheme($theme);

      } else if( $request->gallery_home ){
        $gallery_home = $request->gallery_home;
        return $gallery_home;
      } else if( $request->topColor ){
          $themeTopColor = $request->topColor['theme_top_color'];
          $company->topcolor  = $themeTopColor;
          $company->save();
          return $themeTopColor;
      } else if( $request->configSaveBtn ){

          $themeTopColor = $request->configSaveBtn['topcolor'];
          $config_top_text_color = $request->configSaveBtn['config_top_text_color'];
          $config_top_link_color = $request->configSaveBtn['config_top_link_color'];
          $config_top_link_hover_color = $request->configSaveBtn['config_top_link_hover_color'];
          $config_show_top_title = ($request->configSaveBtn['config_show_top_title'] == 'true') ? 1 : 0 ;
          $config_show_top_phone = ($request->configSaveBtn['config_show_top_phone'] == 'true') ? 1 : 0 ;
          $config_show_top_email = ($request->configSaveBtn['config_show_top_email'] == 'true') ? 1 : 0 ;
          $config_top_text = $request->configSaveBtn['config_top_text'];
          $config_menu_back_color = $request->configSaveBtn['config_menu_back_color'];
          $config_menu_link_color = $request->configSaveBtn['config_menu_link_color'];
          $config_menu_link_hover_color = $request->configSaveBtn['config_menu_link_hover_color'];
          $config_footer_text_color = $request->configSaveBtn['config_footer_text_color'];
          $config_footer_link_color = $request->configSaveBtn['config_footer_link_color'];
          $config_footer_link_hover_color = $request->configSaveBtn['config_footer_link_hover_color'];
          //$config_custom_css = $request->configSaveBtn['config_custom_css'];
          $config_hide_contact = $request->configSaveBtn['config_hide_contact'];
          $config_show_commands = $request->configSaveBtn['config_show_commands'];
          $config_menu_position = $request->configSaveBtn['config_menu_position'];
          $config_menu_min_height = $request->configSaveBtn['config_menu_min_height'];
          $config_menu_has_logo = ($request->configSaveBtn['config_menu_has_logo'] == 'true') ? 1 : 0 ;
          $config_menu_logo_position = $request->configSaveBtn['config_menu_logo_position'];

          $company->topcolor = $themeTopColor;
          $company->config_top_text_color = $config_top_text_color;
          $company->config_top_link_color = $config_top_link_color;
          $company->config_top_link_hover_color = $config_top_link_hover_color;
          $company->config_show_top_title = $config_show_top_title;
          $company->config_show_top_phone = $config_show_top_phone;
          $company->config_show_top_email = $config_show_top_email;
          $company->config_top_text = $config_top_text;
          $company->config_menu_back_color = $config_menu_back_color;
          $company->config_menu_link_color = $config_menu_link_color;
          $company->config_menu_link_hover_color = $config_menu_link_hover_color;
          $company->config_footer_text_color = $config_footer_text_color;
          $company->config_footer_link_color = $config_footer_link_color;
          $company->config_footer_link_hover_color = $config_footer_link_hover_color;
          //$company->config_custom_css = $config_custom_css;
          $company->config_hide_contact = $config_hide_contact;
          $company->config_show_commands = $config_show_commands;
          $company->config_menu_position = $config_menu_position;
          $company->config_menu_min_height = $config_menu_min_height;
          $company->config_menu_has_logo = $config_menu_has_logo;
          $company->config_menu_logo_position = $config_menu_logo_position;

          $company->save();
          return $company;
      } else {
        return response("Not found", 404)
               ->header('Content-Type', 'text/plain');
      }
    }

    public function downloadTheme($id) {
      if(! isset($_REQUEST["theme"]) ) {
        $message = "theme not found";
        return $this->editSettings($id)->withErrors($message);
      }

      $name = $_REQUEST["theme"];
      $zipname = Site::downloadTheme($name);
      header('Content-Type: application/zip');
      header('Content-disposition: attachment; filename='.$zipname);
      header('Content-Length: ' . filesize($zipname));
      readfile($zipname);
      unlink($zipname);
    }

    public function uploadTheme(Request $request, $company_id) {
      $error = null;
      $zipfile = $request->file('zipfile');
      if(!$zipfile) {
        $error = "file not found";
      } else if ($zipfile->path() == '') {
        $error = "file not found";
      } else if( $zipfile->getError() > 0) {
        $error = $zipfile->getErrorMessage();
      }
      if($error != null) {
        return $this->editSettings($company_id)->withErrors($error);
      }
      $res = Site::uploadTheme($zipfile->path());
      if(!$res) {
        $error = "error with upload";
        return $this->editSettings($company_id)->withErrors($error);
      } else {
        return Redirect::route ( 'company.edit.settings', $company_id)->with('success', 'Upload successful !');

      }
    }
    public function uploadCssFile(Request $req, $company_id) {
      $error = null;
      $cssfile = $req->file('cssfile');
      if(!$cssfile) {
        $error = "file not found";
      } else if($cssfile->getError() > 0) {
        $error = $cssfile->getErrorMessage();
      }
      if($error != null) {
        return $this->editSettings($company_id)->withErrors($error);
      }
      $res = Site::uploadCssFile($cssfile);
      if(!$res) {
        $error = "error with upload";
        return $this->editSettings($company_id)->withErrors($error);
      } else {
        return Redirect::route ( 'company.edit.settings', $company_id)->with('success', 'Upload successful !');
      }
    }

    /** Mise à jour des infos de localisation */
    public function updateLocation(EditCompanyLocationRequest $request, $id)
    {
        $company = Company::find($id);
        $coordinate = Coordinate::find($company->coordinate_id);
        $coordinate->adresse = $request->adresse;
        $coordinate->code_postal = $request->cp;
        $coordinate->location_id = $request->ville;
        $coordinate->save();

        return Redirect::route ( 'company.edit', $id)->with ( 'success', "La localisation a été mise à jour avec succès");
    }

    /** Mise à jour des activités proposées*/
    public function updateActivities(Request $request, $id)
    {
        $company = Company::find($id);
        $company->activities()->sync($request->activities != null ? $request->activities : array());

        return Redirect::route ( 'company.edit', $id)->with ( 'success', "Les activités proposées ont été modifiée avec succès");
    }

    public function register(AddCompanyPostRequest $request) {
        // On créé les coordonnées
        $coordinate = new Coordinate();
        $coordinate->set($request);
        $coordinate->save();

        // On écrit les infos de l'entreprise
        $company = new Company ();
        $nom = explode(',', $request->name);
        $company->name = $nom[0];
        $company->slug = $this->generateSlug($company->name);
        $company->mail_news = $request->mailNews;
        $company->coordinate_id = $coordinate->id;
        $company->save ();

        // Création des activités
        $activities = $request->activities != null ? $request->activities : [];
        $company->activities()->sync($activities);

        $user_mails = $request->user_mail;

        if (is_array($user_mails)) {
          for($u = 0; $u < count_of($user_mails); $u++) {
            /** Génération d'un mot de passe */
            $pass = $this->randomString(16);
            $activationToken = $this->randomString(75);

            // Création de la coordonnée
            $coordinate = new Coordinate;
            $coordinate->mail = $request->user_mail[$u];
            $coordinate->tel = $request->user_tel[$u];
            $coordinate->save();

            // Génération des informations
            $user = new User();
            $user->name = $request->user_name[$u] != null ? $request->user_name[$u] : $request->user_first_name[$u] . " " . $request->user_last_name[$u];
            $user->first_name = $request->user_first_name[$u];
            $user->last_name = $request->user_last_name[$u];
            $user->type_id = $request->user_type[$u];
            $user->email = $request->user_mail[$u];
            $user->is_activated = true;
            $user->is_admin = false;
            $user->activation_time = time();
            $user->is_news_enabled = ((isset($request->user_news[$u])) && ($request->user_news[$u] != null));
            $user->activation_token = md5($activationToken);
            $user->reseted_password = Hash::make ($pass);
            $user->pass_secure = $user->reseted_password;
            $user->coordinate_id = $coordinate->id;
            $user->save();

            $companyUser = new CompanyUser();
            $companyUser->company_id = $company->id;
            $companyUser->user_id = $user->id;
            $companyUser->save();

            $mail = $request->user_mail[$u];
            $subject = "Bienvenue sur GoExploria";
            Mail::send ( 'mail.welcome', compact('user', 'activationToken', 'pass'), function ($message) use($mail, $subject) {
              $message->to ( $mail )->subject ( $subject );
            } );
          }
        }

        return Redirect::route ( 'company.search')->with ( 'success', "L'entreprise \"".$company->name."\" a été ajoutée avec succès");
    }

    public function delete($id) {
        Session::reflash('search-company-data');
        $company = Company::find( $id );
        $coordinate = $company->coordinate_id;
        $route = route('company.search', $this->getPage());

        // Si de l'info déjà saisie
        if (count_of($company->pages) > 0) {
            return Redirect::to($route)->with ( 'error', "Suppression impossible, des pages ont été saisies pour l'entreprise");
        }

        $company->delete();
        Coordinate::find($coordinate)->delete();

        return Redirect::to($route)->with ( 'info', "L'entreprise a bien été supprimé");
    }

    public function followers($id) {
        $company = Company::find($id);
        $followers = $company->followers()->orderBy('name')->paginate($this->page);
        $this->storePage();
        return view ( 'back.company.follower' , compact('company', 'followers'));

    }

    /** Suppression d'un abonné */
    public function removeFollower($id, $email) {
        CompanyFollower::where('company_id', $id)->where('email',$email)->delete();
        return Redirect::route('company.follower', [$id, $this->getPage()])->with ( 'info', "L'abonnement a bien été supprimé" );
    }

    /** Suppression d'une liste d'abonnés */
    public function removeFollowerSelected(Request $request,$req2=null) {
        $emails = CompanyFollower::where('company_id', $request->company_id)->whereIn('email',$request->email);
        $count = $emails->count();
        $emails->delete();
        return Redirect::route('company.follower', [$request->company_id, $this->getPage()])->with ( 'info', $count . " abonnements ont bien étés supprimés" );
    }

    // AJAX
    public function getcompaniesbysearch(Request $request) {

      if($request->ajax())
      {
        $companies = Company::where('name', 'like', $request->search.'%')
        #->where('is_activated', true)
        /*
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
            ->from('locations as l')
            ->where('locations.is_activated', true)
            ->whereRaw('l.parent_id = locations.id');
        })
        */
        ->orderBy('name')
        ->select('id', 'name')
        ->get();

        return response()->json($companies);
      } else {
        return response()->json(['error' => 'it fails!']);
      }
    }

    public function deleteLogo(Request $request) {
      if( !$request->has('company_id')) {
        return Redirect::route('company.edit')->withInput()->withErrors("La référence à l'entreprise est manquante!");
      }

      $company = Company::find( $request->company_id );

      if( $request->has('is_headImage') ) {
        $filename = $company->getLogoFilename('headImage');

      } elseif( $request->has('is_footerImage') ) {
        $filename = $company->getLogoFilename('footerImage');

      } else {
        $filename = $company->getLogoFilename();
      }

      $path = public_path('uploads/companies/' . $company->id . '/' . $filename);

      if( !is_file( $path ) ) {
        return Redirect::route('company.edit', $company->id)->withInput()->withErrors("Fichier non trouvé");

      } else {
        @unlink($path);
        return Redirect::route('company.edit', $company->id);
      }

    }
    // Upload logo
    public function updateLogo(Request $request) {
  		if( !$request->has('company_id')) {
        return Redirect::route('company.edit')->withInput()->withErrors("La référence à l'entreprise est manquante!");
      }

      $company = Company::find( $request->company_id );

      if( !$request->hasFile('logo') ) {
        return Redirect::route('company.edit', $company->id )->withInput()->withErrors('Veuillez sélectionner le logo!');
      }

      $suffix = '';
      if( $request->has('is_headImage') ) {
        $suffix = '_headImage';
      } elseif( $request->has('is_footerImage') ) {
        $suffix = '_footerImage';
      } else{
        $suffix = '';
      }

      $file = $request->file('logo');
      $must_resize = $request->has('must_resize') ? true : false;
      $width = !$request->has('width') || $request->width == '0' ? null: $request->width;
      $height = !$request->has('height') || $request->height == '0' ? null: $request->height;

  	  $ext = strtolower($file->getClientOriginalExtension());
  	  $filename = $company->slug . $suffix;

  	  $filename .= '.'.$ext;

      if( in_array($ext, ['jpg', 'jpeg', 'png'] ))
      {
        $filename = $company->id.'/'.$filename;
        $url = base_path().'/public/uploads/companies/' . $filename;
        $company_dir = base_path().'/public/uploads/companies/' . $company->id;

        if( !is_dir( $company_dir ) ){
        	mkdir( $company_dir, 0770 );
        } else {
          if( file_exists( public_path('uploads/companies/' . $company->id . '/' . $company->slug . '.jpg') ) ){
            //@unlink( public_path('uploads/companies/' . $company->id . '/' . $company->slug . '.jpg') );
          } else if( file_exists( public_path('uploads/companies/' . $company->id . '/' . $company->slug . '.png') ) ) {
            //@unlink( public_path('uploads/companies/' . $company->id . '/' . $company->slug . '.png') );
          }
        }

        // http://image.intervention.io/
        $img = Image::make( $file );

        if( $must_resize ) {
          $img->resize($width, $height, function ($constraint) {
            $constraint->upsize();
            $constraint->aspectRatio();
          })->save( $url );

        } else {
          $img->save( $url );
        }

      } else {
        return Redirect::route('company.edit')->withInput()->withErrors('Veuillez choisir une image de type jpg, jpeg ou png.');
      }
    }

    public function deleteListImage(Request $request) {
        if( !$request->has('company_id')) {
            return Redirect::route('company.edit')->withInput()->withErrors("La référence à l'entreprise est manquante!");
        }

        $company = Company::find( $request->company_id );

        $filename = $company->getListImageFilename();

        $path = public_path('uploads/list_images/' . $company->id . '/' . $filename);

        if( !is_file( $path ) ) {
            return Redirect::route('company.edit.infos', $company->id)->withInput()->withErrors("Fichier non trouvé");

        } else {
            @unlink($path);
            return Redirect::route('company.edit.infos', $company->id);
        }

    }
    // Upload list image
    public function updateListImage(Request $request) {
        if( !$request->has('company_id')) {
            return Redirect::route('company.edit')->withInput()->withErrors("La référence à l'entreprise est manquante!");
        }

        $company = Company::find( $request->company_id );

        if( !$request->hasFile('list_image') ) {
            return Redirect::route('company.edit', $company->id )->withInput()->withErrors('Veuillez sélectionner le logo!');
        }

        $file = $request->file('list_image');
        $must_resize = $request->has('must_resize') ? true : false;
        $width = !$request->has('width') || $request->width == '0' ? null: $request->width;
        $height = !$request->has('height') || $request->height == '0' ? null: $request->height;

        $ext = strtolower($file->getClientOriginalExtension());
        $filename = $company->slug;

        $filename .= '.'.$ext;

        if( in_array($ext, ['jpg', 'jpeg', 'png'] ))
        {
            $filename = $company->id.'/'.$filename;
            $url = base_path().'/public/uploads/list_images/' . $filename;
            $company_dir = base_path().'/public/uploads/list_images/' . $company->id;

            if( !is_dir( $company_dir ) ){
                mkdir( $company_dir, 0770 );
            } else {
                if( file_exists( public_path('uploads/list_images/' . $company->id . '/' . $company->slug . '.jpg') ) ){
                    //@unlink( public_path('uploads/companies/' . $company->id . '/' . $company->slug . '.jpg') );
                } else if( file_exists( public_path('uploads/list_images/' . $company->id . '/' . $company->slug . '.png') ) ) {
                    //@unlink( public_path('uploads/companies/' . $company->id . '/' . $company->slug . '.png') );
                }
            }

            // http://image.intervention.io/
            $img = Image::make( $file );

            if( $must_resize ) {
                $img->resize($width, $height, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save( $url );

            } else {
                $img->save( $url );
            }

        } else {
            return Redirect::route('company.edit')->withInput()->withErrors('Veuillez choisir une image de type jpg, jpeg ou png.');
        }
    }

    public function import(Request $request) {
      $activities = Activity::pluck('name', 'id')->all();
      return view ( 'back.company.import', compact('activities'));
    }

    public function importProcess(ImportCompanyPostRequest $request) {
      $file = request()->file('upload');
      $path = $file->move(storage_path() . '/imports', $file->getClientOriginalName());

      $activities = $request->input('activities');

      $count = Importer::Companies($path->getRealPath(), $request->input('ville'), $activities);

      return Redirect::route('company.import')->with('message', 'Un total de ' . $count . ' établissements a été importé avec succès');
    }
}
