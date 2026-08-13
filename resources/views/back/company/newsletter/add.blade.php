@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.newsletter.add', $company) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
<h4>Ajout une newsletter pour : {{$company->name}}</h4>
		<div class="row">
			<div class="col-md-12">
						
				<div class="panel-body">

					 {{ Form::open(array('route' => array('company.newsletter.add.post', $company->id), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) }}

					{{ Form::label('name', "Nom", ['class' => "control-label"]) }}
	                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nom']) }}


	                <br>

					{{ Form::label('content', "Contenu", ['class' => "control-label"]) }}
	                {{ Form::textarea('content', null, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) }}

	                <br><br>

					{{ Form::submit('Ajouter') }}
	                {{ Form::close() }}
				
				</div>
			
			</div>
		</div>

@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\InfolettreRequest', '#addForm'); !!}
@stop
