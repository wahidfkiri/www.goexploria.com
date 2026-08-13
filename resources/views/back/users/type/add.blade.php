@extends('layouts.back.master') 
@section('title', "Types d'utiliateurs")
@section('content')
{!! Breadcrumbs::render('user.type.add') !!}
<h3>Ajouter un type</h3>

 {!! Form::open(['route' => 'user.type.add.post', 'method' => 'post', 'id'=>'add']) !!}
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
		<td>{!! Form::label('slug', 'Identifiant') !!}</td>
		<td class="{!! $errors->has('slug') ? 'has-error' : '' !!}">{!!
			Form::text('slug', null, ['class' => 'form-control',
			'placeholder' => 'Identifiant']) !!} {!! $errors->first('slug', '<small
			class="help-block">:message</small>') !!}
		</td>
	</tr>

	<tr>
		<td>{!! Form::label('content', 'Description') !!}</td>
		<td class="{!! $errors->has('content') ? 'has-error' : '' !!}">{!!
			Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Description']) !!} {!! $errors->first('content', '<small
			class="help-block">:message</small>') !!}
		</td>
	</tr>
</table>

{!! Form::submit('Ajouter', ['class' => 'btn']) !!} 
{{ Form::close() }} 
@stop

@section('js')
{!! JsValidator::formRequest('App\Http\Requests\AddUserTypePostRequest', '#add'); !!}
@stop
