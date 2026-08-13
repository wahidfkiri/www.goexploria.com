@extends('layouts.back.master')
@section('title', 'Pages de destinations')
@section('content')
{!! Breadcrumbs::render('location.page.edit', $country, $location, $page) !!}
	<h4>Editer la page {{$page->name}} de {{ $location->name." (".$location->type->name.")"}}</h4>
		<div class="row">
			<div class="col-md-12">
						
				<div class="panel-body">

					 {{ Form::open(array('route' => array('location.page.edit.post', $country->code, $location->id, $page->id), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) }}

					{{ Form::label('name', "Titre", ['class' => "control-label"]) }}
	                {{ Form::text('name', $page->name, ['class' => 'form-control', 'placeholder' => 'Titre']) }}

	                <br>

					{{ Form::label('rank', "Rang", ['class' => "control-label"]) }}
	                {{ Form::number('rank', $page->rank, ['class' => 'form-control', 'min'=>0, 'placeholder' => 'Rang']) }}

	                <br>

					{{ Form::label('content', "Contenu", ['class' => "control-label"]) }}
	                {!! Form::textarea('content', $page->content, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) !!}

	                <br>

					{{ Form::submit('Modifier') }}
	                {{ Form::close() }}
				
				</div>
			
			</div>
		</div>

@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\PageRequest', '#addForm'); !!}
@stop