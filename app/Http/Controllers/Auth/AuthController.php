<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Déconnecte un membre du site
     */
    public function getLogout() {
        Auth::logout (); // on le déconnecte
        return Redirect::route('index')->with ( 'info', "Déconnexion réussie");
    }

    /**
     * Déconnecte un membre du site
     */
    public function getLogin() {
        return view('front.user.login');
    }

   /**
     * Connecte un membre sur le site
     */
    public function postLogin(Request $request) {
        // Oblige les deux champs à être valides
        $this->validate ( $request, [
                        'identifiant' => 'required',
                        'password' => 'required' 
        ] );
        // On récupère s'il y a une valeur dans le champs caché Redirect
        // On authentifie à partir du mail
        $logValue = $request->identifiant;
        // On garde l'IP et on regarde le nombre de tentatives de connexion
        $throttles = in_array ( ThrottlesLogins::class, class_uses_recursive ( get_class ( $this ) ) );
        // Si trop de tentatives on bloque
        if ($throttles && $this->hasTooManyLoginAttempts ( $request )) {
            return Redirect::route('auth.login')->with ( 'error', "Nombre maximal d'essai atteint" )->withInput ( $request->only ( 'identifiant' ) );
        }
        // On récupère les infos sur l'utilisateur si on les trouve
        $user = User::where ( 'email', $logValue )->first ();
        // On regarde si les mots de passes correspondant
        if (! isset ( $user ) || ! Hash::check ( $request->password, $user->pass_secure )) {
            if ($throttles) { // nouvelle tentative ratée
                $this->incrementLoginAttempts ( $request );
            }
            return Redirect::route('auth.login')->with ( 'error', "Les informations saisies n'ont pas permises de vous identifier" )->withInput ( $request->only ( 'identifiant' ) );
        }
        // On regarde s'il a le droit de se connecter
        if ($user->is_activated) {
            if ($throttles) {
                $this->clearLoginAttempts ( $request );
            }
            
            // On charge les bonnes valeurs dans les variables de session
            Auth::login ( $user, $request->has ( 'remember' ) );
            // on le redirige sur la dernière page qu'il a consulté
            $destination = null;

            // Le mot de passe a été réinisialisé
            if (isset($user->reseted_password) && $user->pass_secure == $user->reseted_password) {
                $destination = route('account.change.pass');
            } else if ($request->redirect != ''){ // Une URL passé en paramètre ?url redirect au login form
                $destination = route('company.edit', ['prefix' => $request->redirect]);
            } else if (Session::has('redirect')) { // Une page est en attente
                $destination = Session::get('redirect');
                Session::forget('redirect');
            } else { // Ou vers une page par défaut
                $destination = route('admin');
            }
            return Redirect::to($destination)->with('success', 'Connexion établie avec succès');
        } else {
            return Redirect::route('auth.login')->with ( 'error', "Votre compte n'a pas encore été activé" )->withInput ( $request->only ( 'identifiant' ) );
        }
    }
    
}
