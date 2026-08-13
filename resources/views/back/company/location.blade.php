@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.edit.location', $company) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
<h4>{{$company->name}} - Localisation</h4>
{!! Form::open(array('route' => array('company.edit.location.post', $company->id), 'method' => 'post','name' => 'companyForm', 'id' => 'editForm')) !!}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<table class='table user'>
		<tr>
			<td>{{ Form::label('ville', "Localisation ( actuellement : " .$company->location->name . " / " . $company->location->type->name . " / " . $company->location->type->country->name . ")", ['class' => "control-label"]) }}</td>
			<td>{{ Form::select('ville', [$company->coordinate->location->id => $company->coordinate->location->name], $company->coordinate->location->id,  ['id' => 'search-engine', 'minChar' => 2, 'placeholder' => 'Ville', 'source' => route('search.location.name', [':data'])]) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('cp', "Code Postal", ['class' => "control-label"]) }}</td>
			<td>{{ Form::text('cp', $company->coordinate->code_postal, ['id' => 'cp', 'class' => 'form-control controls', 'placeholder' => 'Code postal']) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('adresse', "Adresse", ['class' => "control-label"]) }}</td>
			<td>{{ Form::text('adresse', $company->coordinate->adresse, ['id' => 'adresse', 'class' => 'form-control controls', 'placeholder' => 'Adresse']) }}</td>
		</tr>
	</table>

	{{ Form::submit('Modifier')}}
					
{!! Form::close() !!}
@stop
		
@section('js')
	{{ Html::style("css/selectize.css")}}
	{{ Html::script("js/selectize.js")}}
    {{ Html::script("js/search-engine.js")}}
	<!-- Laravel Javascript Validation -->

    {!! JsValidator::formRequest('App\Http\Requests\EditCompanyLocationRequest', '#editForm'); !!}

<script>
    $(document).ready(function () {
		$('#search-engine').searchEngine();
    });
</script>
@stop
