@extends('layouts.back.master-with-left-menu')
@section('title', 'Mon compte')
@section('breadcrumb')
	{!! Breadcrumbs::render('account') !!}
@stop
@section('left-menu')
	@include('back.account.menu')
@stop

@section('right-content')
<h4>Mon compte</h4>

<!-- Info relative au site -->
<div class="seperator"><label>Profil</label></div>
<table class='table user'>
	<tr>
		<th>Email</th>
		<td>{{$user->email}}</td>
	</tr>

	<tr>
		<th>Type de compte</th>
		<td>
			{{ $user->type->name }}
		</td>
	</tr>
	
	<tr>
		<th>Rang</th>
		<td>{{ $user->rang()->name }}</td>
	</tr>

	<tr>
		<th>Newsletter</th>
		<td>{{ $user->news()}}</td>
	</tr>

	<tr>
		<th>Inscrit le</th>
		<td>{{ Formatter::convertDateTime($user->created_at) }}</td>
	</tr>
</table>


<!-- Info relative à la personne -->
<div class="seperator"><label>Identité</label></div>
<table class='table user'>
	<tr>
		<th>Nom complet</th>
		<td>{{ $user->name }}</td>
	</tr>
	<tr>
		<th>Nom</th>
		<td>{{ $user->last_name }} </td>
	</tr>
	<tr>
		<th>Prénom</th>
		<td>{{ $user->first_name }}</td>
	</tr>
</table>

<!-- Info relative à ses coordonnées -->
<div class="seperator"><label>Coordonnées</label></div>
<table class='table user'>
	@if (isset($user->coordinate->location->name))
	 <tr>
		<th>Ville</th>
        <td>{{ $user->coordinate->location->name }}</td>
    </tr>
    @endif

    @if (isset($user->coordinate->code_postal))
	<tr>
	    <th>Code postal</th>
	    <td>{{ $user->coordinate->code_postal }}</td>
    </tr>
    @endif

	@if (isset($user->coordinate->adresse))
	<tr>
	    <th>Adresse</th>
	    <td>{{ $user->coordinate->adresse }}</td>
    </tr>
    @endif

	@if (isset($user->coordinate->tel))
	<tr>
	    <th>Téléphone</th>
	    <td>{{ $user->coordinate->tel }}</td>
    </tr>
    @endif


	@if (isset($user->coordinate->fax))
	<tr>
	    <th>Télécopieur</th>
	    <td>{{ $user->coordinate->fax }}</td>
    </tr>
    @endif

	@if (isset($user->coordinate->website))
	<tr>
	    <th>Site web</th>
	    <td>{{ link_to($user->coordinate->website, $user->coordinate->website) }}</td>
    </tr>
    @endif
</table>
@stop
