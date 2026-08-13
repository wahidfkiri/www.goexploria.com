<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;
use App\Models\User;
use App\Models\CompanyUser;
use App\Models\Company;
use App\Models\UserType;
use App\Models\Coordinate;
use App\Models\NewsletterHistory;
use Redirect;
use Session;
use Hash;
use Mail;
use Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserPostRequest;
use App\Http\Requests\EditUserPostRequest;
use App\Http\Requests\SearchUserRequest;
use App\Http\Requests\AdminUserCreateRequest;
use App\Http\Requests\AdminPassEditRequest;

use DB;

class UserController extends Controller {

  // Page de recherche des utilisateur
  public function index() {
    $users = null;
    $statuts = User::statutsList();
    $rangs = User::rangsList();
    $news = User::newsStatut();
    $types = UserType::orderBy('name')->pluck('name', 'id')->all();

    // $search n'est affecté que dans la branche « recherche enregistrée ».
    // Jusqu'à PHP 7.2, compact() ignorait silencieusement une variable non
    // définie ; depuis PHP 8 cela lève une ErrorException.
    $search = null;

    // Recherche d'un utilisateur dans le cas normal
    if (!Session::has('search-user-data')) {
      // on cherche
      $users = User::orderBy('last_name')
      ->orderBy('first_name');
    } else {
      // recherche dans le cas où l'on a déjà des données enregistrés dans le formulaire
      $request = Session::get('search-user-data');
      $search = $request;
      $users = User::search($request->name, $request->lastName, $request->firstName, $request->mail, $request->type, $request->statut, $request->rang, $request->news);

      // On renvoie la session
      Session::reflash('search-user-data');
    }

    // On stocke la page courante
    $this->storePage();

    // pagination
    $users = $users->paginate($this->page);

    return view ( 'back.users.search', compact('users', 'news', 'rangs', 'search', 'statuts', 'types'));
  }

  // Page de recherche des utilisateurs
  public function search(SearchUserRequest $request) {
    $data = (object) [
      'name' => $request->name,
      'firstName' => $request->firstName,
      'lastName' => $request->lastName,
      'mail' => $request->mail,
      'type' => $request->type == -1 ? '' : $request->type,
      'statut' => $request->statut,
      'rang' => $request->rang,
      'news' => $request->news
    ];
    Session::flash('search-user-data', $data);

    return Redirect::route('user.search' );
  }

  // Suppression des paramètres de recherche
  public function clear() {
    if (Session::has('search-user-data')) {
      Session::forget('search-user-data');
    }

    return Redirect::route('user.search');
  }

  public function delete($id) {
    Session::reflash('search-user-data');
    $route = route('user.search', $this->getPage());
    // Si on tente de se modifier
    if (Auth::user()->id == $id) {
      return Redirect::to($route)->with ( 'error', "Impossible de supprimer son propre compte");
    }

    $user = User::find($id);

    $coordinate = $user->coordinate_id;
    NewsletterHistory::where('user_id', $id)->update(['user_id' => null]);

    // Suppression des galleries de l'utilisateur
    $galleries = $user->galleries()->get();

    foreach($galleries as $gallery) {
      $medias = $gallery->medias()->get();

      foreach($medias as $media) {
        $media->delete();
      }

      $gallery->delete();
    }

    // Suppression des liaisons vers les compagnies
    DB::table('companies_users')->where('user_id', $user->id)->delete();

    // Suppression de l'utilisateur
    $user->delete();
    Coordinate::find($coordinate)->delete();
    return Redirect::to($route)->with ( 'info', "L'utilisateur a bien été supprimé");

  }

  /** Affichage de la liste des utilisateurs inactifs*/
  public function wait() {
    // On efface la recherche
    Session::forget('search-user-data');

    // On cherche les utilisateurs inactifs
    $data = (object) [
      'name' => '',
      'firstName' => '',
      'lastName' => '',
      'mail' => '',
      'type' => '',
      'news' => null,
      'statut' => 0,
      'rang' => null

    ];
    Session::flash('search-user-data', $data);

    return Redirect::route('user.search' );
  }

  /** Inverse le statut d'activation de l'utilisateur sélectionné */
  public function statut($id) {
    Session::reflash('search-user-data');

    // Si on tente de se modifier
    if (Auth::user()->id == $id) {
      return Redirect::route('user.search')->with ( 'error', "Impossible de modifier son propre compte");
    }

    $user = User::find($id);
    $user->is_activated = !$user->is_activated;
    $user->save();
    return Redirect::route('user.search')->with ( 'info', "L'utilisateur ".$user->email ." a bien été ".$user->statut()->txt);
  }

  /** Inverse le rang d'is_activated de l'utilisateur sélectionné */
  public function rang($id) {
    Session::reflash('search-user-data');

    // Si on tente de se modifier
    if (Auth::user()->id == $id) {
      return Redirect::route('user.search')->with ( 'error', "Impossible de modifier son propre compte");
    }

    $user = User::find($id);
    $user->is_admin = !$user->is_admin;
    $user->save();
    return Redirect::route('user.search')->with ( 'info', "L'utilisateur ".$user->email ." a bien été ".$user->rang()->txt);
  }

  /** Formulaire d'ajout d'utilisateur */
  public function add() {
    $types = UserType::orderBy('name')->pluck('name', 'id');
    $typesDetails = UserType::select('id', 'libelle')->get();
    $companies = Company::select(['id','name'])->orderBy('name')->get();

    return view ( 'back.users.add', compact('types', 'typesDetails', 'companies'));
  }

  /** Traitement de l'ajout d'utilisateurs */
  public function register(AdminUserCreateRequest $request) {
    /** Génération d'un mot de passe */
    $pass = $this->randomString(16);
    $activationToken = $this->randomString(75);

    // Création de la coordonnée
    $coordinate = new Coordinate;
    $coordinate->set($request);
    $coordinate->save();

    // Génération des informations
    $user = new User();
    $user->name = $request->name != null ? $request->name : $request->first_name . " " . $request->last_name;
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->type_id = $request->type;
    $user->email = $request->mail;
    $user->is_activated = $request->activation != null;
    $user->is_admin = $request->rang != null;
    $user->activation_time = time();
    $user->is_news_enabled = $request->news != null;
    $user->activation_token = md5($activationToken);
    $user->reseted_password = Hash::make ($pass);
    $user->pass_secure = $user->reseted_password;
    $user->coordinate_id = $coordinate->id;
    $user->save();



    if($request->company_id && !is_null($request->company_id) && $request->company_id != "null") {
      $companyUser = new CompanyUser();
      $companyUser->company_id = $request->company_id;
      $companyUser->user_id = $user->id;
      $companyUser->save();
    }

    $mail = $request->mail;
    $subject = "Bienvenue sur GoExploria";
    Mail::send ( 'mail.welcome', compact('user', 'activationToken', 'pass'), function ($message) use($mail, $subject) {
      $message->to ( $mail )->subject ( $subject );
    } );

    $destination = $request->continue != null ? route('user.add') : route('user.search');
    return Redirect::to($destination)->with("success", "Le compte de " . $user->email . " a bien été créé");

  }

  public function details($id) {
    $user = User::find($id);
    return view('back.users.details', compact('user'));
  }

  public function password($id) {
    $user = User::find($id);
    return view('back.users.pass', compact('user'));
  }

  public function passwordUpdate(AdminPassEditRequest $request, $id) {
    $user = User::find($id);
    $user->pass_secure = Hash::make ($request->new);
    $user->save();
    return Redirect::route('user.details', $id)->with("success", "Le mot de passe a bien été modifié");
  }






}
