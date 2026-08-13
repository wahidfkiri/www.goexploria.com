<?php namespace App\Http\Controllers;


class UploadController extends Controller {

	public function upload(){

		if(request()->hasFile('file')){

			echo '<h3>Votre fichier a été importé avec succès dans notre base de données. Voici comment il apparaitra : </h3>';
			echo '<br><br>';
			$file = request()->file('file');
			$file->move('uploads', $file->getClientOriginalName());
			echo '<img src="uploads/' . $file->getClientOriginalName() . '"/>';
			echo '<h3>Vous pouvez gérer son affichage dans la partie gestion des médias </h3>';		
		} 

	}
}
