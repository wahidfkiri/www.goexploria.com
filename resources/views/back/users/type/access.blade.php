@extends('layouts.back.master')
@section('title', 'Utilisateurs - Permissions')
@section('content')
{!! Breadcrumbs::render('user.type.access', $type) !!}
<h3>Gestion des permissions pour {{$type->name}}</h3>

 {{ Form::open(['route' => array('user.type.access.post', $type->id), 'method' => 'post', 'id'=>'access']) }}
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Module</th>
			<th>Url</th>
			@foreach($functions as $function)
				<th>{{$function}}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
	@foreach($modules as $module)
	    <tr>
	    	<td>{{$module->name}}</td>
	    	<td>{{$module->key}}</td>
			@foreach($functions as $key => $function)
				<td>{{ Form::checkbox($key.'['.$module->id.']', 1, $type->authorized($key, $module))}}</td>
			@endforeach	
		</tr>
	@endforeach
	</tbody>
</table>	

{{ Form::submit('Valider', ['class' => 'btn']) }} 
{{ Form::close() }} 
		
@stop