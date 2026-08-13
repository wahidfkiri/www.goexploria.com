<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Activity;

use App\Models\ActivityCategory;

use App\Http\Controllers\Controller;

use Redirect;

use App\Http\Requests\AddActivityPostRequest;

use App\Http\Requests\EditActivityPostRequest;

class ActivityController extends Controller
{
	//GET ROUTES
    public function index()
    {
    	$activities = Activity::all();
        return view('back.activity.search', compact('activities'));
    }


    public function add()
    {
        $categories = ActivityCategory::orderBy('name')->pluck('name', 'id')->all();
        return view ( 'back.activity.add', compact('categories'));
    }

    public function delete($id)
    {
            $activity = Activity::find ( $id );
            $activity->delete ();
            return Redirect::route('activity.search')->with('info', "L'activité a bien été supprimée");
    }

    public function edit($id)
    {
        $activity = Activity::find($id);
        $categories = ActivityCategory::orderBy('name')->pluck('name', 'id')->all();
        return view ( 'back.activity.edit', compact('activity', 'categories') );
    }

    //POST ROUTES
    public function register(AddActivityPostRequest $request)
    {
        $activity = new Activity();
        $activity->name = $request->name;
        $activity->category_id = $request->category_id;
        $activity->slug = $this->generateSlug($request->name);

        $activity->save ();
        return Redirect::route('activity.search')->with('success', "L'activité \"".$request->name."\" a été ajoutée avec succès");
    }

    public function update(EditActivityPostRequest $request, $id)
    {
        $activity = Activity::find($id);
        $activity->name = $request->name;
        $activity->category_id = $request->category_id;
        $activity->slug = $this->generateSlug($request->slug);

        $activity->save ();
        return Redirect::route('activity.search')->with('success', "L'activité \"".$request->name."\" a été modifée avec succès");
    }

}
