@extends('layouts.back.master-with-left-menu')
@section('title', 'Destination')

@section('breadcrumb')
	{!! Breadcrumbs::render('location.edit.slider', $country, $location) !!}
@stop

@section('left-menu')
	@include('back.location.menu')
@stop

@section('right-content')
<h4><b>{{ Formatter::slugToNames($location->slugify()) }}</b> : Slider</h4>
{{ Form::open(array('route' => array('location.edit.hierarchie.post', $country->code, $location->id), 'method' => 'post', 'id' => 'editForm')) }}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<table class='table user'>
		<tr>
			<td>{{ Form::label('locationType', "Type de destination*") }}</th>
			<td>{{ Form::select('locationType', $type, $location->type->id,  ['class' => 'form-control']) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('parentID', "Parent de la destination") }}</th>
			<td>{{ Form::select('parentID', $location->head != null ? [$location->head->id => $location->head->name] : [], $location->head != null ? $location->head->id : null,  ['id' => 'search-engine', 'minChar' => 2, 'placeholder' => 'Parent', 'source' => route('search.location.parent', [$country->code, ':data'])]) }}</td>
		</tr>
	</table>
	{{ Form::submit('Modifier') }}
{{ Form::close() }}

@stop
