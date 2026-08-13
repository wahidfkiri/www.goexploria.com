@extends('layouts.back.master') 
@section('title', "Modules - Permissions")
@section('content')
{!! Breadcrumbs::render('module.add') !!}
<h3>Ajouter un module</h3>

 {!! Form::open(['route' => 'module.add.post', 'method' => 'post', 'id'=>'add']) !!}
<table class='table user'>

	<tr>
		<td>{!! Form::label('name', 'Nom') !!}</td>
		<td class="{!! $errors->has('name') ? 'has-error' : '' !!}">{!!
			Form::text('name', null, ['class' => 'form-control',
			'placeholder' => 'Nom']) !!} {!! $errors->first('name', '<small
			class="help-block">:message</small>') !!}
		</td>
	</tr>

	<tr>
		<td>{!! Form::label('key', 'Clé') !!}</td>
		<td class="{!! $errors->has('key') ? 'has-error' : '' !!}">{!!
			Form::text('key', null, ['class' => 'form-control',
			'placeholder' => 'Clé']) !!} {!! $errors->first('key', '<small
			class="help-block">:message</small>') !!}
		</td>
	</tr>

</table>

{!! Form::submit('Ajouter', ['class' => 'btn']) !!} 
{{ Form::close() }} 
@stop

@section('js')
{!! JsValidator::formRequest('App\Http\Requests\ModuleRequest', '#add'); !!}
@stop
