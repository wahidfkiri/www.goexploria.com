@extends('layouts.back.master')
@section('title', 'Pages de destinations')
@section('content')
{!! Breadcrumbs::render('location.page.add', $country, $location) !!}
	<h4>Ajouter une page pour : {{ $location->name." (".$location->type->name.")"}}</h4>
		<div class="row">
			<div class="col-md-12">
						
				<div class="panel-body">

					 {{ Form::open(array('route' => array('location.page.add.post', $country->code, $location->id), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) }}

					{{ Form::label('name', "Titre*", ['class' => "control-label"]) }}
	                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Titre']) }}

	                <br>

					{{ Form::label('rank', "Rang", ['class' => "control-label"]) }}
	                {{ Form::number('rank', null, ['class' => 'form-control', 'min'=>0, 'placeholder' => 'Rang']) }}

	                <br>

					{{ Form::label('content', "Contenu*", ['class' => "control-label"]) }}
	                {{ Form::textarea('content', null, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) }}

	                <br>
	                {{Form::checkbox('visible', 'true')}} {{ Form::label('visible', "Visible ?", ['class' => "control-label"]) }}
	                <br><br>

					{{ Form::submit('Ajouter') }}
	                {{ Form::close() }}
				
				</div>
			
			</div>
		</div>

@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\PageRequest', '#addForm'); !!}
@stop