<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Redirect;
use Mail;
use Auth;
use Log;
use App\Http\Controllers\Controller;
use App\Models\Infolettre;
use App\Models\Company;
use App\Models\CompanyFollower;
use App\Http\Requests\InfolettreRequest;
use Aws\Ses\Exception\SesException;

class InfolettreController extends Controller {

	public function index($company) {
		$company = Company::find($company);
		$newsletters = Infolettre::where('company_id', $company->id)->orderBy('name')->get();
		$statuts = Infolettre::statuts();	
		return view('back.company.newsletter.search', compact('newsletters', 'statuts', 'company'));
	}
	
	public function delete($company, $id) {
		$company = Company::find($company);
		$news = Infolettre::find($id);
		if ($news->isSended()) {
			return Redirect::route('company.newsletter.search', [$company->id])->with('error', "Impossible de supprimer, la newsletter a déjà été envoyée");
		}

		$news->delete();
		return Redirect::route('company.newsletter.search', [$company->id])->with('info', "La newsletter a bien été supprimée");
	}

	public function add($company) {
		$company = Company::find($company);
		return view('back.company.newsletter.add', compact('company'));
	}

	public function register(InfolettreRequest $request, $company) {
		$company = Company::find($company);
		$news = new Infolettre();
		$news->name = $request->name;
		$news->content = $request->content;
		$news->company_id = $company->id;
		$news->save();
		return Redirect::route('company.newsletter.search', [$company->id])->with('success', "La newsletter ". $news->name . " a bien été ajoutée");
	}

	public function edit($company, $id) {
		$company = Company::find($company);
		$news = Infolettre::find($id);
	    
	    // Bloque l'édition d'une news envoyée
		if ($news->isSended()) {
			return Redirect::route('company.newsletter.search', [$company->id])->with('error', "La newsletter ". $news->name . " a déjà été envoyé");
		}


		return view('back.company.newsletter.edit', compact('news', 'company'));
	}

	public function update(InfolettreRequest $request, $company, $id) {
		$company = Company::find($company);
		$news = Infolettre::find($id);

		// Bloque l'édition d'une news envoyée
		if ($news->isSended()) {
			return Redirect::route('company.newsletter.search', [$company->id])->with('error', "La newsletter ". $news->name . " a déjà été envoyé");
		}

		$news->name = $request->name;
		$news->content = $request->content;
		$news->save();
		return Redirect::route('company.newsletter.search', [$company->id])->with('success', "La newsletter ". $news->name . " a bien été modifée");
	}

	public function send($company, $id) {
		$company = Company::find($company);
		$news = Infolettre::find($id);

		// Bloque l'envoi d'une news envoyée
		if ($news->isSended()) {
			return Redirect::route('company.newsletter.search', [$company->id])->with('error', "La newsletter ". $news->name . " a déjà été envoyé");
		}

		// On récupère les destinataires
		$users = CompanyFollower::where('company_id', $company->id)->select('name', 'email')->get();
		$subject = "Actualités";

		// On envoie
    try {
      foreach ($users as $user) {
        $mail = $user->email;
        Mail::send ( 'mail.infolettre', compact('user', 'news', 'company'), function ($message) use($mail, $subject, $company) {
          $message->from($company->mail_news, $company->name)->to ( $mail )->subject ( $subject );
        } );
      }
    } catch(SesException $e) {
      Log::warning($e);
      return Redirect::route('company.newsletter.search', [$company->id])->with('error', 'Une erreur s\'est produite: '. $e->getAwsErrorCode() );
    }

		// On met à jour la date d'envoi
		$news->sended_at = time();
		$news->save();
		return Redirect::route('company.newsletter.search', [$company->id])->with('info', "La newsletter ". $news->name . " a bien été envoyée");

	}

}
