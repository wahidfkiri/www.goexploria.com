@extends('layouts.back.master-with-left-menu')
@section('title', 'Mon compte')
@section('breadcrumb')
	{!! Breadcrumbs::render('account.subscription') !!}
@stop
@section('left-menu')
	@include('back.account.menu')
@stop

@section('right-content')
<h4>Mon compte : abonnements</h4>
{{Form::open(['route' => 'account.subscription.add.post', 'method' => 'post',
'id'=>'edit']) }}
<!-- Nouvel abonnement -->
<div class="seperator"><label>Ajouter un abonnement</label></div>
<table class='table user'>
	 <tr>
		<th>{{ Form::label('company', "Entreprise") }}</th>
        <td >{{ Form::select('company', [], null,  ['id' => 'search-engine-company', 'minChar' => 2, 'placeholder' => 'Entreprise', 'source' => route('search.company.name', [':data'])]) }}</td>
    </tr>
    <tr>
    	<td colspan='2'>{{ Form::submit("M'abonner", ['class' => 'button mid-width btn-medium']) }} </td>
    </tr>
</table>
{{ Form::close() }} 

<!-- Liste des abonnements -->
<div class="seperator"><label>Mes abonnements</label></div>
@if(count_of($user->subscriptions) > 0)
<table class='table table-bordered table-striped'>
	<tr>
		<th>Entreprise</th>
		<th>Destination</th>
		<th>Pays</th>
		<th>Actions</th>
	</tr>
	@foreach($user->subscriptions as $subscription)
	 <tr>
	 	<td>
	 		{{$subscription->company->name}} 
	 		{!! Formatter::linkWithIcon(route('front.company.id', $subscription->company->id), 'fa fa-mail-forward', null, ['target' => '_blank']) !!}
	 	</td>
	 	<td>
	 		{{$subscription->company->location->name}} 
	 		{!! Formatter::linkWithIcon(route('front.location.id', $subscription->company->location->id), 'fa fa-mail-forward', null, ['target' => '_blank']) !!}
	 	</td>
	 	<td>
	 		{{$subscription->company->location->country->name}} 
	 		{!! Formatter::linkWithIcon(route('front.country.id', $subscription->company->location->country->id), 'fa fa-mail-forward', null, ['target' => '_blank']) !!}
	 	</td>
	 	<td>
	 		{!! Formatter::deleteButton($subscription->company->id)!!}

			{!! Formatter::delete(route('account.subscription.delete', $subscription->company->id), $subscription->company->id, "Supprimer un abonnement", "Etes-vous sûr de vouloir supprimer l'abonnement à l'infolettre de ".$subscription->company->name ." ?" ) !!}
		</td>
    </tr>
    @endforeach
</table>
@else
	Vous n'êtes abonnés à aucune infolettre
@endif
@stop

@section('js')
{!! JsValidator::formRequest('App\Http\Requests\SubscriptionAddRequest', '#edit'); !!}
	{{ Html::script("js/selectize.js")}}
    {{ Html::script("js/search-engine.js")}}
    {{ Html::style("css/selectize.css")}}
    <script type='text/javascript'>
$(document).ready(function() {
  	$('#search-engine-company').searchEngine();

    $(".delete").click(function(){
        var value = $(this).attr('data');
	    $('#modal-delete-'+value).modal('show');
	
    	return false;
    });
});
</script>
@stop

