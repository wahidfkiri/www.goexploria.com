@extends('layouts.back.master')
@section('title', "Utiliateur")
@section('content')
{!! Breadcrumbs::render('user.details', $user) !!}
<h3>Profil de {{$user->name}}</h3>

<p>
	{!! Formatter::button(route('user.rang', [$user->id]), 'warning', 'fa fa-level-'.($user->is_admin ? 'down' : 'up'), $user->rang()->action)!!}

	{!! Formatter::button(route('user.statut', [$user->id]), 'warning', 'fa fa-'.($user->is_activated ? 'ban' : 'check'), $user->statut()->action)!!}

	{!! Formatter::button(route('user.pass', [$user->id]), 'default', 'fa fa-pencil', "Password")!!}

	{!! Formatter::deleteButton($user->id)!!}

	{!! Formatter::delete(route('user.delete', $user->id), $user->id, "Supprimer un utilisateur", "Etes-vous sûr de vouloir supprimer le compte de ".$user->email ." ?" ) !!}
</p>


<!-- Info relative au site -->
<div class="seperator"><label>Profil</label></div>
<table class='table user'>
	<tr>
		<th>Email</th>
		<td>{{$user->email}}</td>
	</tr>

	<tr>
		<th>Type de compte</th>
		<td>{{ $user->type->name }}</td>
	</tr>

  <tr>
    <th>Entreprises</th>
    <td>
      @if($user->companies)
        @foreach($user->companies as $company)
          {{ $company->name }}<br>
        @endforeach
      @endif
    </td>
  </tr>

	<tr>
		<th>Rang</th>
		<td>{{ $user->rang()->name }}</td>
	</tr>

	<tr>
		<th>Activation</th>
		<td>{{ $user->statut()->name }}</td>
	</tr>

	<tr>
		<th>Newsletter</th>
		<td>{{ $user->news()}}</td>
	</tr>

	<tr>
		<th>Inscription</th>
		<td>{{ Formatter::convertDateTime($user->created_at) }}</td>
	</tr>

	<tr>
		<th>Mise à jour</th>
		<td>{{ Formatter::convertDateTime($user->updated_at) }}</td>
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

@section('js')
<script type="text/javascript">
	$(document).ready(function() {

	    $(".delete").click(function(){
	        var value = $(this).attr('data');
		    $('#modal-delete-'+value).modal('show');

	    	return false;
	    });
	});
</script>
@stop
