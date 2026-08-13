<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Redirect;
use Hash;
use Auth;
use Mail;
use App\Http\Requests\PostPassRequest;

class PasswordController extends Controller
{
    public function getResetForm()
    {
        return view('front.user.password-reset');
    }

    public function postResetForm(Request $request)
    {
        // On teste si l'adresse mail est bonne
        $this->validate($request, ['email' => 'required|email']);
        $mail = $request->email;

        // On récupère l'utilisateur associé à l'adresse email
        $user = User::where('email', $mail)->first();

        // Utilisateur non trouvé
        if ($user == null) {
            return Redirect::route('auth.reset.pass')->with('error', 'Impossible de trouver un compte associé à cette adresse email');
        } // else

        // On génère un nouveau mot de passe et un token
        $newPass = $this->randomString(16);
        $resetToken = $this->randomString(75);

        // On met à jour la BDD
        $user->pass_reset_time = time();
        $user->pass_reset_token = md5($resetToken);
        $user->reseted_password = Hash::make ($newPass);
        $user->save();

        // On envoi le mail
        $subject = "Réinisialisation de mot de passe";
        Mail::send ( 'mail.password', compact('user', 'newPass', 'resetToken'), function ($message) use($mail, $subject) {
            $message->to ( $mail )->subject ( $subject );
        } );        

        return Redirect::route('auth.login')->with('success', 'Un nouveau mot de passe vous a été renvoyé');
    }

    /** Modification du mot de passe */
    public function getReset($token) {
        // On récupère l'utilisateur associé au token
        $user = User::where('pass_reset_token', md5($token))->first();

        // Si le délai est dépasse on sort
        if (time() - $user->pass_reset_time > $this->expireTime) {
            return Redirect::route('auth.login')->with('error', 'Mot de passe expiré, refaites une demande');
        }


        // Sinon on change le mot de passe
        $user->pass_secure = $user->reseted_password;
        $user->save();
        return Redirect::route('auth.login')->with('success', 'Le mot de passe a bien été modifié');

    }


}
