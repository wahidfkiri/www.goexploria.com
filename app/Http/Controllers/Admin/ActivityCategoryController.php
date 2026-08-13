<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Models\Activity;

use App\Models\ActivityCategory;

use Redirect;

use App\Http\Requests\AddActivityCategoryPostRequest;

use App\Http\Requests\EditActivityCategoryPostRequest;

class ActivityCategoryController extends Controller
{
   	//GET ROUTES
    public function index()
    {
        $categories = ActivityCategory::all();;
        return view('back.activity.category.search', compact('categories'));
    }

    public function add()
    {
        $types = ActivityCategory::types();
        return view ( 'back.activity.category.add', compact('types') );
    }

    public function delete($id)    {
         $category = ActivityCategory::find ( $id );
        if (count ($category->activities) > 0) {
            return Redirect::route('activity.category.search')->with ( 'error', "Suppression impossible, il existe des activités dans cette catégorie");
        } else {
            $category->delete ();
            return Redirect::route('activity.category.search')->with ( 'info', "La catégorie a bien été supprimée");;
        }
    }

    public function edit($id)
    {
        $category = ActivityCategory::find($id);
        $types = ActivityCategory::types();
        return view ( 'back.activity.category.edit', compact('category', 'types'));
    }

    //POST ROUTES
    public function register(AddActivityCategoryPostRequest $request)
    {
        $category = new ActivityCategory ();
        $category->name = $request->name;
        $category->slug = $this->generateSlug($request->name);
        $category->type_id = $request->type_id;

        $category->save ();
        return Redirect::route('activity.category.search')->with ( 'success', "La catégorie \"".$request->name."\" a été ajoutée avec succès");
    }

    public function update(EditActivityCategoryPostRequest $request, $id)
    {
        $category = ActivityCategory::find($id);
        $category->name = $request->name;
        $category->slug = $this->generateSlug($request->slug);
        $category->type_id = $request->type_id;

        $category->save ();
        return Redirect::route('activity.category.search')->with ( 'success', "La catégorie \"".$request->name."\" a été modifiée avec succès");
    }


}
