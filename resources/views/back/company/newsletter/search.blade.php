@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.newsletter', $company) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
<h4>{{$company->name}} : Newsletters </h4>
	{!! Formatter::addButton(route('company.newsletter.add', $company->id))!!}

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
						<td>{{ Form::label('statut', 'Statut') }}</td>
						<td>{{ Form::select('statut', ['-1' => 'Tous'] + $statuts, null, ['id' => 'statut-search', 'class' => 'form-control']) }}</td>
					</tr>
				</table>
				{{ Form::hidden('statut', null, ["data-column"=>"1", 'id' => 'col1_filter']) }}

				{{ Form::button("<i class='entypo-search'></i> Rechercher", ['class'=>'btn btn-success btn-sm btn-icon icon-left', 'id' => 'search']) }}
				{{ Form::button("<i class='entypo-cancel'></i> Effacer", ['id'=> 'clear', 'class'=>'btn btn-primary btn-sm btn-icon icon-left']) }}
			</div>
		</div>

		<table class="table table-bordered table-striped datatable" id="table">
			<thead>
				<tr>
					<th>Titre</th>
					<th>Statut</th>
					<th>Création</th>
					<th>Dernière modification</th>
					<th>Envoyé le</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			@foreach($newsletters as $newsletter)
			    <tr>
					<td class="search-name">{{ $newsletter->name }}</td>
					<td class='search-statut' data='{{($newsletter->isSended() ? 1 : 0)}}'>{{ $newsletter->statut() }}</td>
					<td>{{Formatter::convertDateTime($newsletter->created_at)}}</td>
					<td>{{Formatter::convertDateTime($newsletter->updated_at)}}</td>
					<td>{{$newsletter->sended_at != null ? Formatter::convertTimestampToDateTime($newsletter->sended_at) : "Jamais"}}</td>
					<td>
						{!! Formatter::previewButton($newsletter->id)!!}

						{!! Formatter::button(route('company.newsletter.send', [$company->id, $newsletter->id]), 'primary', 'fa-envelope', 'Envoyer')!!}

						{!! Formatter::editButton(route('company.newsletter.edit', [$company->id, $newsletter->id]))!!}



						{!! Formatter::deleteButton($newsletter->id)!!}

						{!! Formatter::preview($newsletter->id, $newsletter->content)!!}

						{!! Formatter::delete(route('company.newsletter.delete', [$company->id, $newsletter->id]), $newsletter->id, "Supprimer une newsletter", "Voulez-vous vraiment supprimer la newsletter " .$newsletter->name ." ?" ) !!}

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
	           	$(".search-statut").click(function(){
		            var value = $(this).attr('data');
    	            $('#statut-search').val(value);
    	            searchStatut($('#statut-search'));
	            });

	            $('#statut-search').on('change', function() {
	            	searchStatut($(this));
	            });

	            function searchStatut(src) {
					var data = src.val() >= 0 ? src.find("option:selected").text() : '';

    	            $('#col1_filter').val(data);
    	            search();
	            }
				
	            
	            /** bouton de recherche  */
	            $("#search").click(function(){
		            search();		            
	            });
	            
	            /** Recherhe */
	            function search() {
	                filterColumn($('#col0_filter').attr('data-column'));
	                filterColumn($('#col1_filter').attr('data-column'));
	            }
			    
			    /** Vidage des champs */
			    $("#clear").click(function(){
			        $('#col0_filter').val('');
			        $('#col1_filter').val(-1);
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
