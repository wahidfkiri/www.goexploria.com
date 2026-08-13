@extends('layouts.back.master') 
@section('title', "Contenu")
@section('content')
{!! Breadcrumbs::render('content.index', $content) !!}

	{!! Form::open(['route' => ['content.index', $content->id], 'method' => 'post', 'id'=>'edit']) !!}
	<table class='table user'>

		<tr>
			<td>
				{!! Form::label('phone', 'Téléphone') !!}
			</td>
			<td class="{!! $errors->has('phone') ? 'has-error' : '' !!}">
				{{ Form::text('phone', $content->phone, ['class' => 'full-width', 'placeholder' => '(888) 888-8888']) }}
			</td>
		</tr>
		<tr>
			<td>
				{!! Form::label('email', 'Courriel') !!}
			</td>
			<td class="{!! $errors->has('email') ? 'has-error' : '' !!}">
				{{ Form::text('email', $content->email, ['class' => 'full-width', 'placeholder' => 'mon@courriel.com']) }}
			</td>
		</tr>
		<tr>
			<td>
				{!! Form::label('meta_description', 'Meta Description') !!}
			</td>
			<td class="{!! $errors->has('meta_description') ? 'has-error' : '' !!}">
				{{ Form::text('meta_description', $content->meta_description, ['class' => 'full-width', 'placeholder' => 'Meta Description']) }}
			</td>
		</tr>
		<tr>
			<td>
				{!! Form::label('facebook_link', 'Lien Facebook') !!}
			</td>
			<td class="{!! $errors->has('facebook_link') ? 'has-error' : '' !!}">
				{{ Form::text('facebook_link', $content->facebook_link, ['class' => 'full-width', 'placeholder' => 'Lien Facebook']) }}
			</td>
		</tr>
		<tr>
			<td>
				{!! Form::label('twitter_link', 'Lien Twitter') !!}
			</td>
			<td class="{!! $errors->has('twitter_link') ? 'has-error' : '' !!}">
				{{ Form::text('twitter_link', $content->twitter_link, ['class' => 'full-width', 'placeholder' => 'Lien Twitter']) }}
			</td>
		</tr>
		<tr>
			<td>
				{!! Form::label('youtube_link', 'Lien Youtube') !!}
			</td>
			<td class="{!! $errors->has('youtube_link') ? 'has-error' : '' !!}">
				{{ Form::text('youtube_link', $content->youtube_link, ['class' => 'full-width', 'placeholder' => 'Lien Youtube']) }}
			</td>
		</tr>
		<tr>
			<td>
				{!! Form::label('pinterest_link', 'Lien Pinterest') !!}
			</td>
			<td class="{!! $errors->has('pinterest_link') ? 'has-error' : '' !!}">
				{{ Form::text('pinterest_link', $content->pinterest_link, ['class' => 'full-width', 'placeholder' => 'Lien Pinterest']) }}
			</td>
		</tr>
		<tr>
			<td>
				{!! Form::label('instagram_link', 'Lien Instagram') !!}
			</td>
			<td class="{!! $errors->has('instagram_link') ? 'has-error' : '' !!}">
				{{ Form::text('instagram_link', $content->instagram_link, ['class' => 'full-width', 'placeholder' => 'Lien Instagram']) }}
			</td>
		</tr>
		<tr>
			<td>
				{!! Form::label('home_intro', 'Accueil - Intro') !!}
			</td>
			<td class="{!! $errors->has('home_intro') ? 'has-error' : '' !!}">
				{{ Form::textarea('home_intro', $content->home_intro, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) }}
			</td>
		</tr>
		<tr>
			<td>
				{!! Form::label('home_outro', 'Accueil - Outro') !!}
			</td>
			<td class="{!! $errors->has('home_outro') ? 'has-error' : '' !!}">
				{{ Form::textarea('home_outro', $content->home_outro, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) }}
			</td>
		</tr>
		<tr>
			<td>
				{!! Form::label('footer_text', 'Pied de page') !!}
			</td>
			<td class="{!! $errors->has('footer_text') ? 'has-error' : '' !!}">
				{{ Form::textarea('footer_text', $content->footer_text, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) }}
			</td>
		</tr>



	</table>

	{!! Form::submit('Modifier', ['class' => 'btn']) !!}
	{{ Form::close() }}
@stop

@section('js')
{!! JsValidator::formRequest('App\Http\Requests\ContentRequest', '#index') !!}
@stop
