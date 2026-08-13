@extends('layouts.back.master-with-left-menu')
@section('title', 'Destination')
@section('breadcrumb')
	{!! Breadcrumbs::render('location.edit.contact', $country, $location) !!}
@stop
@section('left-menu')
	@include('back.location.menu')
@stop

@section('right-content')
<h4><b>{{ Formatter::slugToNames($location->slugify()) }}</b> : Point d'informations</h4>
{{ Form::open(array('route' => array('location.edit.contact.post', $country->code, $location->id), 'method' => 'post', 'id' => 'editForm')) }}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<table class='table user'>
		<tr>
			<td>{{ Form::label('ville', "Localisation", ['class' => "control-label"]) }}</td>
			<td>{{ Form::select('ville', $location->coordinate != null && $location->info != null ? [$location->info->id => $location->info->name] : [], $location->coordinate != null && $location->info != null ? $location->info->id : null,  ['id' => 'search-engine', 'minChar' => 2, 'placeholder' => 'Ville', 'source' => route('search.location.parent', [$country->code, ':data'])]) }}
			</td>
		</tr>
		<tr>
			<td>{{ Form::label('cp', "Code Postal", ['class' => "control-label"]) }}</td>
			<td>{{ Form::text('cp', $location->coordinate != null ? $location->coordinate->code_postal : null, ['id' => 'cp', 'class' => 'form-control controls', 'placeholder' => 'Code postal']) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('adresse', "Adresse", ['class' => "control-label"]) }}</td>
			<td>{{ Form::text('adresse', $location->coordinate != null ? $location->coordinate->adresse : null, ['id' => 'adresse', 'class' => 'form-control controls', 'placeholder' => 'Adresse']) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('tel', "Téléphone", ['class' => "control-label"]) }}</td>
			<td>{{ Form::text('tel', $location->coordinate != null ? $location->coordinate->tel : null, ['id' => 'tel', 'class' => 'form-control controls', 'placeholder' => 'Téléphone']) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('fax', "Télécopieur", ['class' => "control-label"]) }}</td>
			<td>{{ Form::text('fax', $location->coordinate != null ? $location->coordinate->fax : null, ['id' => 'fax', 'class' => 'form-control controls', 'placeholder' => 'Télécopieur']) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('mail', "Email", ['class' => "control-label"]) }}</td>
			<td>{{ Form::text('mail', $location->coordinate != null ? $location->coordinate->mail : null, ['id' => 'mail', 'class' => 'form-control controls', 'placeholder' => 'Adresse email']) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('website', "Site web", ['class' => "control-label"]) }}</td>
			<td>{{ Form::text('website', $location->coordinate != null ? $location->coordinate->website : null, ['id' => 'website', 'class' => 'form-control controls', 'placeholder' => 'Site Web']) }}</td>
		</tr>
	</table>
	{{ Form::submit('Modifier') }}
{{ Form::close() }}

@stop
@section('js')
{!! JsValidator::formRequest('App\Http\Requests\LocationContactRequest', '#editForm'); !!}
	{{ Html::style("css/selectize.css")}}
	{{ Html::script("js/selectize.js")}}
    	{{ Html::script("js/search-engine.js")}}
		<!-- Barre de recherche -->
<script type='text/javascript'>
$(document).ready(function() {
  $('#search-engine').searchEngine();
});
</script>
@stop