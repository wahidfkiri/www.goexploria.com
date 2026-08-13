@extends('layouts.back.master')
@section('title', 'Pages de pays')
@section('content')
{!! Breadcrumbs::render('country.page', $country) !!}
<h3>Pages du pays : {{$country->name}} 		{!! Formatter::button(route('front.country.id', [$country->id]), 'info', 'entypo-eye', 'Voir')!!}</h3>

		{!! Formatter::addButton(route('country.page.add', [$country->code]))!!}

		</br></br>

		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					Rechercher
				</div>
						
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
					
			<div class="panel-body">
				<table class="table">
					<tr>
						<td>{{ Form::label('name', 'Titre') }}</td>
						<td>{{ Form::text('name', null, ["data-column"=>"0", 'id' => 'col0_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Titre']) }}</td>
					</tr>

					<tr>
						<td>{{ Form::label('statut', 'Visibilité') }}</td>
						<td>{{ Form::select('statut', ['-1' => 'Toutes'] + $statuts, null, ['id' => 'visible-search', 'class' => 'form-control']) }}</td>
					</tr>
				</table>
				{{ Form::hidden('visible', null, ["data-column"=>"2", 'id' => 'col2_filter']) }}

				{{ Form::button("<i class='entypo-search'></i> Rechercher", ['class'=>'btn btn-success btn-sm btn-icon icon-left', 'id' => 'search']) }}
				{{ Form::button("<i class='entypo-cancel'></i> Effacer", ['id'=> 'clear', 'class'=>'btn btn-primary btn-sm btn-icon icon-left']) }}
			</div>
		</div>

		<table class="table table-bordered table-striped datatable" id="table">
			<thead>
				<tr>
					<th>Titre</th>
					<th>Rang</th>
					<th>Visibilité</th>
					<th>Création</th>
					<th>Dernière modification</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			@foreach($country->pages as $page)
			    <tr>
					<td class="search-name">{{ $page->name }}</td>
					<td>{{ $page->rank }}</td>
					<td class='search-visible' data='{{$page->visibility}}'>{{ $page->statut() }}</td>
					<td>{{Formatter::convertDateTime($page->created_at)}}</td>
					<td>{{Formatter::convertDateTime($page->updated_at)}}</td>
					<td>

						{!! Formatter::previewButton($page->id)!!}

						{!! Formatter::button(route('country.page.visibility', [$country->code, $page->id]), 'warning', 'fa-eye'.($page->visibility == 1 ? '-slash' : ''), str_replace('ée', 'er', $page->opposite()))!!}

						{!! Formatter::editButton(route('country.page.edit', [$country->code, $page->id]))!!}

						{!! Formatter::deleteButton($page->id)!!}

						{!! Formatter::preview($page->id, $page->content)!!}

						{!! Formatter::delete(route('country.page.delete', [$country->code, $page->id]), $page->id, "Supprimer une page", "Voulez-vous vraiment supprimer la page " .$page->name ." ?" ) !!}

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		
		
		<br />
		<br />

@stop
@section('js')
	<!-- Laravel Javascript Validation -->
	{{ Html::script('js/jquery/dataTables.min.js') }}  
		
		<script type='text/javascript'>
			$(document).ready(function() {
			    $('#table').DataTable({
			    	sDom: '<"top"l>rt<"bottom"ip><"clear">',
			    	"order": [[ 0, "asc" ]],
			    	"drawCallback": function( settings ) {
        				callback();
  					}
				});
			    function filterColumn ( i ) {
			        $('#table').DataTable().column( i ).search(
			            $('#col'+i+'_filter').val()
			        ).draw();
			    }
			    
			    // recherche
			    $('input.column_filter').on( 'keyup click', function () {
			        filterColumn($(this).attr('data-column'));
			    } );
			    
			    
			    
			    /** Clique sur le nom */
	            $(".search-name").click(function(){
		            var value = $(this).html();
    	            $('#col0_filter').val(value);
    	            search();
	            });

	            /** Recherche sur la visibilité */
	           	$(".search-visible").click(function(){
		            var value = $(this).attr('data');
    	            $('#visible-search').val(value);
    	            searchStatut($('#visible-search'));
	            });

	            $('#visible-search').on('change', function() {
	            	searchStatut($(this));
	            });

	            function searchStatut(src) {
					var data = src.val() >= 0 ? src.find("option:selected").text() : '';

    	            $('#col2_filter').val(data);
    	            search();
	            }
				
	            
	            /** bouton de recherche  */
	            $("#search").click(function(){
		            search();		            
	            });
	            
	            /** Recherhe */
	            function search() {
	                filterColumn($('#col0_filter').attr('data-column'));
	                filterColumn($('#col2_filter').attr('data-column'));
	            }
			    
			    /** Vidage des champs */
			    $("#clear").click(function(){
			        $('#col0_filter').val('');
			        $('#col2_filter').val('');
			        $('#visible-search').val(-1);
			        search();	            
	            });
			    
		/**************************************************************/
	    /************************* SUPPRESSION ************************/
	    /**************************************************************/
	    function callback() {
	 	   $(".delete").click(function(){
	    	    var value = $(this).attr('data');
			    $('#modal-delete-'+value).modal('show');
	    		return false;
	    	});

	    	$(".preview").click(function(){
	        	var value = $(this).attr('data');
		    	$('#modal-preview-'+value).modal('show');
	    		return false;
	    	});
	    }

    });   
			</script>
@stop
