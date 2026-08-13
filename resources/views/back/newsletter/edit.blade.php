@extends('layouts.back.master')
@section('title', 'Newsletter')
@section('content')
{!! Breadcrumbs::render('newsletter.edit', $news) !!}
	<h4>Editer une newsletter : {{$news->name }}</h4>
		<div class="row">
			<div class="col-md-12">
						
				<div class="panel-body">

					 {{ Form::open(array('route' => array('newsletter.edit.post', $news->id), 'method' => 'post', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered')) }}

					{{ Form::label('name', "Nom", ['class' => "control-label"]) }}
	                {{ Form::text('name', $news->name, ['class' => 'form-control', 'placeholder' => 'Nom']) }}


	                <br>

					{{ Form::label('content', "Contenu", ['class' => "control-label"]) }}
	                {{ Form::textarea('content', $news->content, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) }}

	                <br><br>

					{{ Form::submit('Modifier') }}
	                {{ Form::close() }}
				
				</div>
			
			</div>
		</div>

@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\NewsletterRequest', '#editForm'); !!}
@stop
