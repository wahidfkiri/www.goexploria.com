<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyComment;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyCommentRequest;

class CompanyCommentController extends Controller {


	// Company TYPE
	// GET ROUTES
	public function add($company) {
		$company = Company::find($company);		

		return view ( 'back.company.comment.add', compact('company'));
	}
	public function edit($company, $id) {
		$company = Company::find($company);		
		$comment = CompanyComment::find( $id );
		return view ( 'back.company.comment.edit' , compact('comment', 'company'));
	}


	public function delete($company, $id) {
		CompanyComment::find($id)->delete();
		return Redirect::route('company.comment.search', [ $company] )->with ( 'info', "Le commentaire a bien été supprimé");
	}

	public function index($company) {
		$company = Company::find($company);
		return view ( 'back.company.comment.search', compact('company') );
	}

	// POST ROUTES
	public function register(CompanyCommentRequest $request, $company) {
		$comment = new CompanyComment();
		$comment->content = $request->content;
		$comment->company_id = $company;
		$comment->save ();

		return Redirect::route ( 'company.comment.search', [
				$company
		] )->with ( 'success', "Le commentaire a été ajouté avec succès");;
	}
	public function update(CompanyCommentRequest $request, $company, $id) {
		$comment = CompanyComment::find ($id);	
		$comment->content = $request->content;
		$comment->save ();

		return Redirect::route ( 'company.comment.search', [
				 $company
		] )->with ( 'success', "Le commentairea été modifié avec succès");
	}


}
