@extends('layouts.back.master-with-left-menu')
@section('title', 'Mon compte')
@section('breadcrumb')
	{!! Breadcrumbs::render('account.edit') !!}
@stop
@section('left-menu')
	@include('back.account.menu')
@stop

@section('right-content')
<h4>Mon compte : modification</h4>
{{Form::open(['route' => 'account.edit.post', 'method' => 'post',
'id'=>'edit']) }}
<!-- Info relative au site -->
<div class="seperator"><label>Mon profil</label></div>
<table class='table user'>
	<tr>
		<th>Email</th>
		<td>{{$user->email}}</td>
	</tr>

	<tr>
		<th>Type de compte</th>
		<td>{{ $user->type->name }}</td>
	</tr>

</table>

<!-- Info relative à la personne -->
<div class="seperator"><label>Mes informations</label></div>
<table class='table user'>
	<tr>
		<th>{{ Form::label('name', 'Nom complet') }}</th>
		<td >{{ Form::text('name', $user->name, ['placeholder' => 'Nom complet', 'class' => 'form-control']) }}</td>
	</tr>
	<tr>
		<th>{{ Form::label('last_name', 'Nom*') }}</th>
		<td >{{ Form::text('last_name', $user->last_name, ['placeholder' => 'Nom', 'class' => 'form-control']) }}</td>
	</tr>
	<tr>
		<th>{{ Form::label('first_name', 'Prénom*') }}</th>
		<td >{{ Form::text('first_name', $user->first_name, ['placeholder' => 'Prénom', 'class' => 'form-control']) }}</td>
	</tr>
</table>

<!-- Info relative à ses coordonnées -->
<div class="seperator"><label>Mes coordonnées</label></div>
<table class='table user'>
	 <tr>
		<th>{{ Form::label('ville', "Localisation") }}</th>
        <td >{{ Form::select('ville', isset($user->coordinate->location) ? [$user->coordinate->location->id => $user->coordinate->location->name] : [], isset($user->coordinate->location) ? $user->coordinate->location->id : null,  ['id' => 'search-engine-location', 'minChar' => 2, 'placeholder' => 'Ville', 'source' => route('search.location.name', [':data'])]) }}</td>
    </tr>

    <tr>
	    <th>{{ Form::label('cp', "Code Postal") }}</th>
	    <td >{{ Form::text('cp', isset($user->coordinate->code_postal) ? $user->coordinate->code_postal : null, ['placeholder' => 'Code postal', 'class' => 'form-control']) }}</td>
    </tr>

	<tr>
	    <th>{{ Form::label('adresse', "Adresse") }}</th>
	    <td >{{ Form::text('adresse', isset($user->coordinate->adresse) ? $user->coordinate->adresse : null, ['placeholder' => 'Adresse', 'class' => 'form-control']) }}</td>
    </tr>

	<tr>
	    <th>{{ Form::label('tel', "Téléphone") }}</th>
	    <td >{{ Form::text('tel', isset($user->coordinate->tel) ? $user->coordinate->tel : null, ['placeholder' => 'Téléphone', 'class' => 'form-control']) }}</td>
    </tr>

	<tr>
	    <th>{{ Form::label('fax', "Télécopieur") }}</th>
	    <td>{{ Form::text('fax', isset($user->coordinate->fax) ? $user->coordinate->fax : null, ['placeholder' => 'Télécopieur', 'class' => 'form-control']) }}</td>
    </tr>

	<tr>
	    <th>{{ Form::label('website', "Site web") }}</th>
	    <td >{{ Form::text('website', isset($user->coordinate->website) ? $user->coordinate->website : null , ['placeholder' => 'Site Web', 'class' => 'form-control']) }}</td>
    </tr>
</table>

<p>
	{{Form::checkbox('news', 'true', $user->is_news_enabled)}} 	 {{ Form::label('news', "Recevoir les newsletters et les offres ?", ['class' => "control-label"]) }}
</p>

{{ Form::submit('Modifier', ['class' => 'button mid-width btn-medium']) }} {{
Form::close() }} 
@stop

@section('js')
{!! JsValidator::formRequest('App\Http\Requests\UserUpdateRequest', '#edit'); !!}
	{{ Html::script("js/selectize.js")}}
    {{ Html::script("js/search-engine.js")}}
    {{ Html::style("css/selectize.css")}}
    <script type='text/javascript'>
$(document).ready(function() {
  $('#search-engine-location').searchEngine();
});
</script>
@stop

