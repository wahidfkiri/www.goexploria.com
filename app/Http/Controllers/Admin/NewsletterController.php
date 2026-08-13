<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Redirect;
use Mail;
use Auth;
use Log;
use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\User;
use App\Models\NewsletterHistory;
use App\Http\Requests\NewsletterRequest;
use Aws\Ses\Exception\SesException;

class NewsletterController extends Controller {

	public function index() {
		$newsletters = Newsletter::orderBy('name')->get();
		$statuts = Newsletter::statuts();	
		return view('back.newsletter.search', compact('newsletters', 'statuts'));
	}
	
	public function delete($id) {
		$news = Newsletter::find($id);
		if ($news->isSended()) {
			return Redirect::route('newsletter.search')->with('error', "Impossible de supprimer, la newsletter a déjà été envoyée");
		}

		$news->delete();
		return Redirect::route('newsletter.search')->with('info', "La newsletter a bien été supprimée");
	}

	public function add() {
		return view('back.newsletter.add');
	}

	public function register(NewsletterRequest $request) {
		$news = new Newsletter();
		$news->name = $request->name;
		$news->content = $request->content;
		$news->save();
		return Redirect::route('newsletter.search')->with('success', "La newsletter ". $news->name . " a bien été ajoutée");
	}

	public function edit($id) {
		$news = Newsletter::find($id);
	    
	    // Bloque l'édition d'une news envoyée
		if ($news->isSended()) {
			return Redirect::route('newsletter.search')->with('error', "La newsletter ". $news->name . " a déjà été envoyé");
		}


		return view('back.newsletter.edit', compact('news'));
	}

	public function update(NewsletterRequest $request, $id) {
		$news = Newsletter::find($id);

		// Bloque l'édition d'une news envoyée
		if ($news->isSended()) {
			return Redirect::route('newsletter.search')->with('error', "La newsletter ". $news->name . " a déjà été envoyé");
		}

		$news->name = $request->name;
		$news->content = $request->content;
		$news->save();
		return Redirect::route('newsletter.search')->with('success', "La newsletter ". $news->name . " a bien été modifée");
	}

	public function send($id) {
		$news = Newsletter::find($id);

		// On récupère les destinataires
		$users = User::where('is_news_enabled', true)->where('is_activated', true)->select('name', 'email')->get();
		$subject = "Actualités";

    try {
      // On envoie
      foreach ($users as $user) {
        $mail = $user->email;

        Mail::queue ( 'mail.newsletter', compact('user', 'news'), function ($message) use($mail, $subject) {
          $message->to ( $mail )->subject ( $subject );
        });
      }

    } catch(SesException  $e) {
      Log::warning($e);
      return Redirect::route('newsletter.search')->with('error', 'Une erreur s\'est produite: '. $e->getAwsErrorCode());
    }

		// On ajoute à l'historique
		$history = new NewsletterHistory();
		$history->newsletter_id = $id;
		$history->sended_at = time();
		$history->user_id = Auth::user()->id;
		$history->save();

		return Redirect::route('newsletter.search')->with('info', "La newsletter ". $news->name . " a bien été envoyée");

	}

	public function history() {
		$sends = NewsletterHistory::orderBy('sended_at', 'desc')->get();
		return view('back.newsletter.history', compact('sends'));
	}


	
	
}
