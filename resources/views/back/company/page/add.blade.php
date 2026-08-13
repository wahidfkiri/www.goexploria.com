@extends('layouts.back.master-with-left-menu')
@section('title', 'Pages des établissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.page.add', $company) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
	<h4>Ajouter une page pour : {{ $company->name}}</h4>
		<div class="row">
			<div class="col-md-12">
						
				<div class="panel-body">

					 {{ Form::open(array('route' => array('company.page.add.post',  $company->id), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) }}

					{{ Form::label('name', "Titre*", ['class' => "control-label"]) }}
	                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Titre']) }}

	                <br>

					{{ Form::label('rank', "Rang", ['class' => "control-label"]) }}
	                {{ Form::number('rank', null, ['class' => 'form-control', 'min'=>0, 'placeholder' => 'Rang']) }}

	                <br>

					{{ Form::label('content', "Contenu*", ['class' => "control-label"]) }}
	                {{ Form::textarea('content', null, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) }}

	                <br>

					{{ Form::label('language', "Langue*", ['class' => "control-label"]) }}
					{!!Form::select('language', $languages, null, ['class' => 'form-control'])!!}

					<br>

					{{ Form::label('is_home', "Est la page d'accueil?", ['class' => "control-label"]) }}
					{{ Form::checkbox('is_home', null) }}

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
