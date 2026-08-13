<?php

namespace App\Http\Controllers;

use Session;
use Response;
use View;
use Redirect;
use Hash;
use Auth;
use App\Models\User;
use App\Models\UserType;
use App\Models\Coordinate;
use App\Models\CompanyFollower;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\PostPassRequest;
use App\Http\Requests\SubscriptionAddRequest;
use Illuminate\Http\Request;

class AccountController extends Controller {
 /** Page d'édition du mot de passe */
    public function editPass() {
        return view('back.account.password-change');
    }

    /** Envoi de la modification du mot de passe */
    public function updatePass(PostPassRequest $request) {
        // On récupère les infos de l'utilisateur
        $user = User::find(Auth::user()->id);

        // On sort si le mot de passe actuel n'est pas bon
        if (!Hash::check ( $request->current, $user->pass_secure )) {
            return Redirect::route('account.change.pass')->with('error', "Le mot de passe actuel est erronné");
        }

        // On met à jour le mot de passe
        $user->pass_secure = Hash::make ($request->new);

        // On supprime les infos du mot de passe de backup si elles existent
        $route = null;
        if ($user->reseted_password != null) {
            $user->reseted_password = null;
            $user->pass_reset_token = null;
            $route = 'index';
        } else {
            $route = 'account.change.pass';
        }

        // On sauvegarde
        $user->save();
        return Redirect::route($route)->with('success', "Le mot de passe a bien été modifé");
    }

     /**
     * Page de modification du compte
     */
    public function edit() {
        $user = User::find ( Auth::user ()->id );
        return view ( 'back.account.edit', compact ( 'user') );
    }

    /**
     * Mise à jour des informations
     */
    public function update(UserUpdateRequest $request) {
        // Mise à jour des infos
        $user = User::find ( Auth::user ()->id );
        $user->name = $request->name != null ? $request->name : $request->first_name . " " . $request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->is_news_enabled = $request->news != null;
        $user->save ();

        // Mise à jour des coordonnées
        $coordinate = Coordinate::find($user->coordinate_id);
        $coordinate->set($request);
        $coordinate->save();

        // Mise à jour du nom pour les abonnemments
        CompanyFollower::where('email', '=', $user->email)->update(array('name' => $user->name));

        return Redirect::route('account.edit')->with ( 'success', "Votre compte " . $user->email . " a bien été modifié." );
    }

    /**
     * Page de gestion des abonnements
     */
    public function subscription() {
        $user = User::find ( Auth::user ()->id );
        return view ( 'back.account.subscription', compact ( 'user') );
    }

    /** Ajout d'un abonnement */
    public function subscriptionAdd(SubscriptionAddRequest $request) {

        // Abonnement déjà présent
        if (CompanyFollower::isAFollower($request->company, Auth::user()->email)) {
            return Redirect::route('account.subscription.search')->with ( 'error', "Vous êtes déjà abonné à cette entreprise" );
        }

        $subscription = new CompanyFollower();
        $subscription->company_id = $request->company;
        $subscription->email = Auth::user()->email;
        $subscription->name = Auth::user()->name;
        $subscription->save();

        return Redirect::route('account.subscription.search')->with ( 'success', "L'abonnement a bien été ajouté" );


    }

    /** Suppression d'un abonnement */
    public function subscriptionDelete($company) {
        CompanyFollower::where('company_id', $company)->where('email', Auth::user()->email)->delete();

        return Redirect::route('account.subscription.search')->with ( 'info', "L'abonnement a bien été supprimé" );

    }

    /** Affichage du profil */
    public function profil() {
        $user = Auth::user();
        return view('back.account.profil', compact('user'));
    }


}
