<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\UserType;
use App\Models\Module;
use Redirect;
use Session;
use App\Models\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserTypePostRequest;
use App\Http\Requests\EditUserTypePostRequest;

class UserTypeController extends Controller {

	public function index() {
		$types = UserType::orderBy('name')->get();
		return view('back.users.type.search', compact('types'));
	}
	
	public function delete($id) {
		$type = UserType::find($id);
		if (count_of($type->users) != 0) {
			return Redirect::route('user.type.search')->with('error', "Impossible de supprimer le type, des comptes l'utilisent");
		}
		$type->delete();
		return Redirect::route('user.type.search')->with('success', "Le type a bien été supprimé");
	}

	public function add() {
		return view('back.users.type.add');
	}

	public function register(AddUserTypePostRequest $request) {
		$type = new UserType();
		$type->name = $request->name;
		$type->libelle = $request->content;
		$type->slug = $this->generateSlug($request->slug);
		$type->save();

		return Redirect::route('user.type.search')->with('success', "Le type ".$type->name." a bien été ajouté");
	}

	public function edit($id) {
		$type = UserType::find($id);
		return view('back.users.type.edit', compact('type'));
	}

	public function update(EditUserTypePostRequest $request, $id) {
		$type = UserType::find($id);
		$type->name = $request->name;
		$type->libelle = $request->content;
		$type->save();

		return Redirect::route('user.type.search')->with('success', "Le type ".$type->name." a bien été modifié");
	}

	public function access($id) {
		$type = UserType::find($id);
		$modules = Module::orderBy('key')->get();
		$functions = Permission::permissionsList();
		return view('back.users.type.access', compact('type', 'modules', 'functions'));
	}

	public function accessChange(Request $request, $id) {
		// On récupère le type à modifier
		$type = UserType::find($id);

		// On supprime les permissions existantes
        Permission::where('type_id', $id)->delete();

		// On met à jour les consultations
		if (isset($request->read)) {
			foreach ($request->read as $key => $value) {
				$type->modules()->attach($key, array('key' => 'read'));
			}
		}

		// On met à jour les ajouts
		if (isset($request->add)) {
			foreach ($request->add as $key => $value) {
				$type->modules()->attach($key, array('key' => 'add'));
			}
		}

		// On met à jour les editions
		if (isset($request->edit)) {
			foreach ($request->edit as $key => $value) {
				$type->modules()->attach($key, array('key' => 'edit'));
			}
		}

		// On met à jour les suppressions
		if (isset($request->delete)) {
			foreach ($request->delete as $key => $value) {
				$type->modules()->attach($key, array('key' => 'delete'));
			}
		}

		return Redirect::route('user.type.access', $id)->with('success', "Les permissions ont bien été mise à jour");
	}


	
	
}
