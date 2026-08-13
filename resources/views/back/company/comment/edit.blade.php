@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.comment.edit', $company, $comment) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
	<h4>Editer un commentaire pour {{$company->name}} : {{$comment->name }}</h4>
		<div class="row">
			<div class="col-md-12">
						
				<div class="panel-body">

					 {{ Form::open(array('route' => array('company.comment.edit.post', $company->id, $comment->id), 'method' => 'post', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered')) }}

					{{ Form::label('content', "Contenu", ['class' => "control-label"]) }}
	                {{ Form::textarea('content', $comment->content, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) }}

	                <br><br>

					{{ Form::submit('Modifier') }}
	                {{ Form::close() }}
				
				</div>
			
			</div>
		</div>

@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\CompanyCommentRequest', '#editForm'); !!}
@stop
