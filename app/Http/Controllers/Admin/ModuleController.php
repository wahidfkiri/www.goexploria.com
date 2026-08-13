<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Http\Requests\ModuleRequest;
use Redirect;

class ModuleController extends Controller {

	public function index() {
		$modules = Module::orderBy('name')->get();
		return view('back.config.module.search', compact('modules'));
	}
	
	public function delete($id) {
		Module::find($id)->delete();
		return Redirect::route('module.search')->with('info', "Le module a bien été supprimé");
	}

	public function add() {
		return view('back.config.module.add');
	}

	public function register(ModuleRequest $request) {
		$module = new Module();
		$module->name = $request->name;
		$module->key = $request->key;
		$module->save();
		
		return Redirect::route('module.search')->with('succes', "Le module ".$module->name." a bien été ajouté");
	}

	public function edit($id) {
		$module = Module::find($id);
		return view('back.config.module.edit', compact('module'));
	}

	public function update(ModuleRequest $request, $id) {
		$module = Module::find($id);
		$module->name = $request->name;
		$module->key = $request->key;
		$module->save();

		return Redirect::route('module.search')->with('succes', "Le module ".$module->name." a bien été modifié");

	}
}
