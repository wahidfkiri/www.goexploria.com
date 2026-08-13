@extends('layouts.back.master')
@section('title', 'Etablissements')
@section('content')
{!! Breadcrumbs::render('company') !!}
<h3>Liste des établissements</h3>
	{!! Formatter::addButton(route('company.add'))!!}

		</br></br>


		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					Rechercher
				</div>
						
			</div>
					
			<div class="panel-body">
				{{ Form::open(array('route' => array('company.search.post'), 'method' => 'post')) }}
				<table class="table">
					<tr>
						<td>{{ Form::label('name', 'Nom') }}</td>
						<td>{{ Form::text('name', isset($search) ? $search->name : '', ['id' => 'name-search', 'class' => 'form-control', 'placeholder' => 'Nom']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('country', 'Pays') }}</td>
						<td>{{ Form::text('country', isset($search) ? $search->country : '', ['id' => 'country-search', 'class' => 'form-control', 'placeholder' => 'Pays']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('location', 'Destination') }}</td>
						<td>{{ Form::text('location', isset($search) ? $search->location : '', ['id' => 'location-search', 'class' => 'form-control', 'placeholder' => 'Destination']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('activities', 'Activités') }}</td>
						<td>{{ Form::text('activities', isset($search) ? $search->activities : '', ['id' => 'activities-search', 'class' => 'form-control', 'placeholder' => 'Activités']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('mail', 'Email') }}</td>
						<td>{{ Form::text('mail', isset($search) ? $search->mail : '', ['id' => 'mail-search', 'class' => 'form-control', 'placeholder' => 'Email']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('tel', 'Téléphone') }}</td>
						<td>{{ Form::text('tel', isset($search) ? $search->tel : '', ['id' => 'tel-search', 'class' => 'form-control', 'placeholder' => 'Téléphone']) }}</td>
					</tr>
				</table>

				{{ Form::button("<i class='entypo-search'></i> Rechercher", ['class'=>'btn btn-success btn-sm btn-icon icon-left', 'type' => 'submit']) }}
				<a href="{{ route('company.search.clear') }}">{{ Form::button("<i class='entypo-cancel'></i> Effacer", ['id'=> 'clear', 'class'=>'btn btn-primary btn-sm btn-icon icon-left']) }}</a>
				{{ Form::close() }}
			</div>
		</div>
		
		<table class="table table-bordered table-striped" id="table">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Pays</th>
					<th>Destination</th>
					<th>Activités</th>
					<th>Galeries</th>
					<th>Email</th>
					<th>Téléphone</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			@foreach($companies as $company)
		    <tr>
	        <td class="search-name">{{ $company->name }} </td>
	        <td class="search-country">{{ $company->location->country->name }}</td>
	        <td class="search-location">{{ $company->location->name }}</td>
	        <td class="search-activities">{{ $company->activities()->get()->implode('name', ', ') }}</td>
	        <td class="search-gallery" align="center">@if( $company->galleries->count() > 0 )<a href="{{ route('company.gallery.search', ['cid' => $company->id]) }}"> {{ $company->galleries->count() }} </a> @endif</td>
	        <td class="search-mail">{{ $company->coordinate->mail != null ? $company->coordinate->mail : 'Aucun' }}</td>
	        <td class="search-tel">{{ $company->coordinate->tel != null ? $company->coordinate->tel : 'Aucun' }}</td>
	        <td>

	        	{!! Formatter::seeButton(route('front.company.id', [$company->id]))!!}

	        	{!! Formatter::button(route('company.page.search', [$company->id]), 'primary', 'fa-file-text fa', 'Pages')!!}

						{!! Formatter::editButton(route('company.edit', [$company->id]))!!}



						{!! Formatter::deleteButton($company->id)!!}

						{!! Formatter::delete(route('company.delete', $company->id), $company->id, "Supprimer une entreprise", "Voulez-vous vraiment supprimer l'entreprise " .$company->name ." ?" ) !!}
                 
					</td>      
		    </tr>
			@endforeach
			</tbody>
		</table>
		{{ $companies->render() }}
		
		<br />
		<br />
@stop

@section('js')

<script type="text/javascript">
	$(document).ready(function() {
	
	    /**************************************************************/
	    /************************* SUPPRESSION ************************/
	    /**************************************************************/
	    $(".delete").click(function(){
	        var value = $(this).attr('data');
		    $('#modal-delete-'+value).modal('show');
					
	    	return false;
	    });
		        
	    /**************************************************************/
	    /************************* RECHERCHE **************************/
	    /**************************************************************/
        /* Clique sur le nom */
	    $(".search-name").click(function(){
		    var value = $(this).html();
		    $('#name-search').val(value);
	    });
				
	    /** Clique sur la ville */
	    $(".search-location").click(function(){
		    var value = $(this).html();
    	    $('#location-search').val(value);
	    });
				
	    /** Clique sur le mail */
	    $(".search-mail").click(function(){
		    var value = $(this).html();
		    $('#mail-search').val(value);
	    });

	    /** Clique sur le téléphone */
	    $(".search-tel").click(function(){
		    var value = $(this).html();
		    $('#tel-search').val(value);
	    });

	    /** Clique sur le pays */
	    $(".search-country").click(function(){
		    var value = $(this).html();
		    $('#country-search').val(value);
	    });
	    
} ); 
</script>
@stop
