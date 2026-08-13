<?php

namespace App\Http\Controllers;

use Session;
use Response;
use View;
use Validator;
use Redirect;
use Hash;
use Auth;
use App\Models\User;
use App\Models\UserType;
use App\Models\Coordinate;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Mail;

class MembresControlleur extends Controller {
    /**
     * Page d'inscription
     */
    public function create() {
        $types = UserType::orderBy('name')->pluck('name', 'id');
        $typesDetails = UserType::select('id', 'libelle')->get();

        return view ( 'front.user.create', compact('types', 'typesDetails'));
    }

    /**
     * Traitement de l'inscription
     */
    public function store(UserCreateRequest $request) {
        // On génère un token
        $activationToken = $this->randomString(75);

        // Création de la coordonnée
        $coordinate = new Coordinate;
        $coordinate->set($request);
        $coordinate->save();

        $user = new User ();
        $user->name = $request->name != null ? $request->name : $request->first_name . " " . $request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->type_id = $request->type;
        $user->email = $request->mail;
        $user->is_news_enabled = $request->news != null;
        $user->activation_time = time();
        $user->activation_token = md5($activationToken);
        $user->pass_secure = Hash::make ( $request->password);
        $user->coordinate_id = $coordinate->id;
        $user->save();

        // On envoi le mail
        $mail = $request->mail;
        $subject = "Activation de votre compte";
        Mail::send ( 'mail.activation', compact('user', 'activationToken'), function ($message) use($mail, $subject) {
            $message->to ( $mail )->subject ( $subject );
        } );

        return Redirect::route ('auth.login')->with ( 'success', "Votre compte " . $user->name . " a bien été créé.<p>Vous allez recevoir un email pour l'activer</p>" );

    }


    public function getActivationForm()
    {
        return view('front.user.activation');
    }

    public function resend(Request $request)
    {
        // On teste si l'adresse mail est bonne
        $this->validate($request, ['email' => 'required|email']);
        $mail = $request->email;

        // On récupère l'utilisateur associé à l'adresse email
        $user = User::where('email', $mail)->first();

        // Utilisateur non trouvé
        if ($user == null) {
            return Redirect::route('account.activate.form')->with('error', 'Impossible de trouver un compte associé à cette adresse email');
        } else if ($user->is_activated) {
            return Redirect::route('auth.login')->with('error', 'Votre compte est déjà activé');
        }

        // On génère un token
        $activationToken = $this->randomString(75);

        // On met à jour la BDD
        $user->activation_time = time();
        $user->activation_token = md5($activationToken);
        $user->save();

        // On envoi le mail
        $subject = "Activation de votre compte";
        Mail::send ( 'mail.activation', compact('user', 'activationToken'), function ($message) use($mail, $subject) {
            $message->to ( $mail )->subject ( $subject );
        } );

        return Redirect::route('auth.login')->with('success', "L'email d'activation a bien été envoyé");
    }

    /** Activation du compte */
    public function activate($token) {
        // On récupère l'utilisateur associé au token
        $user = User::where('activation_token', md5($token))->first();

        if(!$user) {
          return Redirect::route('auth.login')->with('error', "Compte déjà activé ou compte jeton invalide.");
        }

        // Si le délai est dépasse on sort
        if (time() - $user->activation_time > $this->expireTime) {
            return Redirect::route('auth.login')->with('error', "Lien d'activation expirée, refaites une demande");
        }

        // Sinon on active
        $user->is_activated = true;
        $user->activation_token = null;
        $user->save();
        return Redirect::route('auth.login')->with('success', 'Votre compte a bien été activé');
    }


    // Formulaire de désinscription de la newsletter
    public function getNewsletterForm()
    {
        return view('front.user.newsletter');
    }

    public function newsletterResign(Request $request)
    {
        // On teste si l'adresse mail est bonne
        $this->validate($request, ['email' => 'required|email']);
        $mail = $request->email;

        // On récupère l'utilisateur associé à l'adresse email
        $user = User::where('email', $mail)->first();

        // Utilisateur non trouvé
        if ($user == null) {
            return Redirect::route('account.newsletter')->with('error', 'Impossible de trouver un compte associé à cette adresse email');
        } else if (!$user->is_news_enabled ) {
            return Redirect::route('index')->with('error', "Vous n'êtes pas abonnés aux newsletters");
        }

        // On met à jour la BDD
        $user->is_news_enabled = false;
        $user->save();

        return Redirect::route('index')->with('info', "Votre souhait de ne plus recevoir de newsletters a bien été enregistré");
    }


}
