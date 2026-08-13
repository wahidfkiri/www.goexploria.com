@extends('layouts.back.master') 
@section('title', "Modules - Permissions")
@section('content')
{!! Breadcrumbs::render('module.edit', $module) !!}
<h3>Modifier un module : {{$module->name}}</h3>

 {!! Form::open(['route' => ['module.edit.post', $module->id], 'method' => 'post', 'id'=>'edit']) !!}
<table class='table user'>

	<tr>
		<td>{!! Form::label('name', 'Nom') !!}</td>
		<td class="{!! $errors->has('name') ? 'has-error' : '' !!}">{!!
			Form::text('name', $module->name, ['class' => 'form-control',
			'placeholder' => 'Nom']) !!} {!! $errors->first('name', '<small
			class="help-block">:message</small>') !!}
		</td>
	</tr>

	<tr>
		<td>{!! Form::label('key', 'Clé') !!}</td>
		<td class="{!! $errors->has('key') ? 'has-error' : '' !!}">{!!
			Form::text('key', $module->key, ['class' => 'form-control',
			'placeholder' => 'Clé']) !!} {!! $errors->first('key', '<small
			class="help-block">:message</small>') !!}
		</td>
	</tr>
</table>

{!! Form::submit('Modifier', ['class' => 'btn']) !!} 
{{ Form::close() }} 
@stop

@section('js')
{!! JsValidator::formRequest('App\Http\Requests\ModuleRequest', '#edit'); !!}
@stop
