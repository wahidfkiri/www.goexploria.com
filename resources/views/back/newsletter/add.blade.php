@extends('layouts.back.master')
@section('title', 'Newsletter')
@section('content')
{!! Breadcrumbs::render('newsletter.add') !!}
	<h4>Ajouter une newsletter</h4>
		<div class="row">
			<div class="col-md-12">
						
				<div class="panel-body">

					 {{ Form::open(array('route' => array('newsletter.add.post'), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) }}

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
    {!! JsValidator::formRequest('App\Http\Requests\NewsletterRequest', '#addForm'); !!}
@stop
