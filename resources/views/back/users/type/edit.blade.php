@extends('layouts.back.master') 
@section('title', "Types d'utiliateurs")
@section('content')
{!! Breadcrumbs::render('user.type.edit', $type) !!}
<h3>Modifier un type : {{$type->name}}</h3>

 {!! Form::open(['route' => ['user.type.edit.post', $type->id], 'method' => 'post', 'id'=>'edit']) !!}
<table class='table user'>

	<tr>
		<td>{!! Form::label('name', 'Nom') !!}</td>
		<td class="{!! $errors->has('name') ? 'has-error' : '' !!}">{!!
			Form::text('name', $type->name, ['class' => 'form-control',
			'placeholder' => 'Nom']) !!} {!! $errors->first('name', '<small
			class="help-block">:message</small>') !!}
		</td>
	</tr>

	<tr>
		<td>{!! Form::label('slug', 'Identifiant') !!}</td>
		<td>{!!
			Form::text('slug', $type->name, ['class' => 'form-control',
			'disabled' => 'disabled']) !!}
		</td>
	</tr>

	<tr>
		<td>{!! Form::label('content', 'Description') !!}</td>
		<td class="{!! $errors->has('content') ? 'has-error' : '' !!}">{!!
			Form::textarea('content', $type->libelle, ['class' => 'form-control', 'placeholder' => 'Description']) !!} {!! $errors->first('content', '<small
			class="help-block">:message</small>') !!}
		</td>
	</tr>
</table>

{!! Form::submit('Modifier', ['class' => 'btn']) !!} 
{{ Form::close() }} 
@stop

@section('js')
{!! JsValidator::formRequest('App\Http\Requests\EditUserTypePostRequest', '#edit'); !!}
@stop
