@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.comment.add', $company) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
<h4>Ajout un commentaire pour : {{$company->name}}</h4>
		<div class="row">
			<div class="col-md-12">
						
				<div class="panel-body">

					 {{ Form::open(array('route' => array('company.comment.add.post', $company->id), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) }}

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
    {!! JsValidator::formRequest('App\Http\Requests\CompanyCommentRequest', '#addForm'); !!}
@stop
