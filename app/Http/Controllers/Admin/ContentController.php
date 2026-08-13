<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Http\Requests\ContentRequest;
use Redirect;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContentRequest $request)
    {
        $content = Content::latest()->first();

        if (!$content) {
            $content = new Content();
            $content->facebook_link = '';
            $content->twitter_link = '';
            $content->youtube_link = '';
            $content->pinterest_link = '';
            $content->instagram_link = '';
            $content->home_intro = '';
            $content->home_outro = '';
            $content->footer_text = '';
            $content->meta_description = '';
            $content->phone = '';
            $content->email = '';
            $content->save();
        }

        if ($request->isMethod('post')) {
            $content->facebook_link = $request->facebook_link;
            $content->twitter_link = $request->twitter_link;
            $content->youtube_link = $request->youtube_link;
            $content->pinterest_link = $request->pinterest_link;
            $content->instagram_link = $request->instagram_link;
            $content->home_intro = $request->home_intro;
            $content->home_outro = $request->home_outro;
            $content->footer_text = $request->footer_text;
            $content->meta_description = $request->meta_description;
            $content->phone = $request->phone;
            $content->email = $request->email;
            $content->save();
        }

/*
        $module->name = $request->name;
        $module->key = $request->key;*/
        //dd($request);

        return view('back.config.content.index', compact('content'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
