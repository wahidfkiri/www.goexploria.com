@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.newsletter.edit', $company, $news) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
	<h4>Editer une newsletter pour {{$company->name}} : {{$news->name }}</h4>
		<div class="row">
			<div class="col-md-12">
						
				<div class="panel-body">

					 {{ Form::open(array('route' => array('company.newsletter.edit.post', $company->id, $news->id), 'method' => 'post', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered')) }}

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
    {!! JsValidator::formRequest('App\Http\Requests\InfolettreRequest', '#editForm'); !!}
@stop
