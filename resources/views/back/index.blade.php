@extends('layouts.back.master')
@section('title', 'Administration')
@section('content')
{!! Breadcrumbs::render('back') !!}

<h1>Administration</h1>
<!-- Utilisateurs -->
<div class='row'>
	<div class="col-sm-3 col-xs-6 tile-stats tile-red registred">
		<div class="icon"><i class="entypo-users"></i></div>
		<div class="num" data-start="0" data-end="{{$usersActivated}}" data-duration="1500" data-delay="0">0</div>
	
		<h3>Utilisateurs enregistrés</h3>
	</div>

	<a href="{{route('user.waiting')}}">
		<div class="col-sm-3 col-xs-6 tile-stats tile-white-red">
			<div class="icon"><i class="entypo-user-add"></i></div>
			<div class="num" data-start="0" data-end="{{$usersUnactivated}}" data-duration="1500" data-delay="0">0</div>
	
			<h3>Utilisateurs en attente</h3>
		</div>
	</a>


	<div class="col-sm-3 col-xs-6 tile-stats tile-red">
		<div class="icon"><i class="entypo-users"></i></div>
		<div class="num" data-start="0" data-end="{{$usersRecentlyRegistred}}" data-duration="1500" data-delay="0">0</div>
	
		<h3>Inscrits récemment</h3>
	</div>

	<!-- Graphique de proportion -->
	<div class="modal fade" id="user-registred">
		<div class="modal-dialog">
			<div class="modal-content">
									
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Types de membres</h4>
				</div>
				<!-- content -->
				<div class="modal-body carte plain" id="registred-chart"></div>
									
				<div class="modal-footer">
					<a href='#' class='close'><button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button></a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Destinations -->
<div class='row'>
	<div class="col-sm-3 col-xs-6 tile-stats tile-white-blue">
		<div class="icon"><i class="entypo-globe"></i></div>
		<div class="num" data-start="0" data-end="{{$countries}}" data-duration="1500" data-delay="0">0</div>
	
		<h3>Pays couverts</h3>
	</div>		

	<div class="col-sm-3 col-xs-6 tile-stats tile-blue">
		<div class="icon"><i class="entypo-map"></i></div>
		<div class="num" data-start="0" data-end="{{$locations}}" data-duration="1500" data-delay="0">0</div>
	
		<h3>Destinations disponibles</h3>
	</div>		

	<div class="col-sm-3 col-xs-6 tile-stats tile-white-blue">
		<div class="icon"><i class="entypo-doc-text-inv"></i></div>
		<div class="num" data-start="0" data-end="{{$locationsPages}}" data-duration="1500" data-delay="0">0</div>
	
		<h3>Pages visibles</h3>
	</div>	
</div>

<!-- Entreprises -->
<div class='row'>
	<div class="col-sm-3 col-xs-6 tile-stats tile-green">
		<div class="icon"><i class="entypo-basket"></i></div>
		<div class="num" data-start="0" data-end="{{$companies}}" data-duration="1500" data-delay="0">0</div>
	
		<h3>Entreprises référencées</h3>
	</div>

	<div class="col-sm-3 col-xs-6 tile-stats tile-white-green">
		<div class="icon"><i class="entypo-doc-text-inv"></i></div>
		<div class="num" data-start="0" data-end="{{$companiesPages}}" data-duration="1500" data-delay="0">0</div>

		<h3>Pages visibles </h3>
	</div>

	<div class="col-sm-3 col-xs-6 tile-stats tile-white-green">
		<div class="icon"><i class="entypo-doc-text-inv"></i></div>
		<div class="num" data-start="0" data-end="{{$visits}}" data-duration="1500" data-delay="0">0</div>

		<h3>Pages de compagnies vues </h3>
	</div>
</div>



<!-- Activités -->
<div class='row'>
	<div class="col-sm-3 col-xs-6 tile-stats tile-white-orange">
		<div class="icon"><i class="entypo-flight"></i></div>
		<div class="num" data-start="0" data-end="{{$activities}}" data-duration="1500" data-delay="0">0</div>
	
		<h3>Types d'activités</h3>
	</div>		

	<div class="col-sm-3 col-xs-6 tile-stats tile-orange">
		<div class="icon"><i class="entypo-flight"></i></div>
		<div class="num" data-start="0" data-end="{{$companiesActivities}}" data-duration="1500" data-delay="0">0</div>
	
		<h3>Activités proposées</h3>
	</div>		
</div>

<!-- Newsletters -->
<div class='row'>
	<div class="col-sm-3 col-xs-6 tile-stats tile-purple">
		<div class="icon"><i class="entypo-mail"></i></div>
		<div class="num" data-start="0" data-end="{{$newsletterSended}}" data-duration="1500" data-delay="0">0</div>
	
		<h3>Newsletters envoyées</h3>
	</div>	
	<div class="col-sm-3 col-xs-6 tile-stats tile-white-purple">
		<div class="icon"><i class="entypo-pencil"></i></div>
		<div class="num" data-start="0" data-end="{{$newsletterNotSended}}" data-duration="1500" data-delay="0">0</div>
	
		<h3>Newsletters en attente</h3>
	</div>		

	<div class="col-sm-3 col-xs-6 tile-stats tile-purple">
		<div class="icon"><i class="entypo-user"></i></div>
		<div class="num" data-start="0" data-end="{{$abonnes}}" data-duration="1500" data-delay="0">0</div>
	
		<h3>Utilisateurs abonnés aux newsletters</h3>
	</div>		
</div>

@stop
@section('js')
	{{Html::script('js/charts/raphael-min.js')}}
	{{Html::script('js/charts/morris.min.js')}}
<script type='text/javascript'>

	Morris.Donut({
  		element: 'registred-chart',
  		data: [
  			@foreach ($usersTypes as $type)
  				{label: "{{$type->name}}", value: {{count_of($type->users)}}},
  			@endforeach
  		]
	});

	$(document).ready(function() {

		/**************************************************************/
	    /************************* SUPPRESSION ************************/
	    /**************************************************************/
	    $(".registred").click(function(){
		    $('#user-registred').modal('show');
	    	return false;
	    });

    });   

	</script>
@stop