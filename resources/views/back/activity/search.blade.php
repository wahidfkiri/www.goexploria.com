@extends('layouts.back.master')
@section('title', "Activités")
@section('content')
{!! Breadcrumbs::render('activity') !!}
<h3>Liste des activités</h3>
	{!! Formatter::addButton(route('activity.add'))!!}

		</br></br>

		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					Rechercher
				</div>
						
			</div>
					
			<div class="panel-body">
				<table class="table">
					<tr>
						<td>{{ Form::label('nom', 'Nom') }}</td>
						<td>{{ Form::text('nom', null, ["data-column"=>"0", 'id' => 'col0_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Nom']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('categorie', 'Catégorie') }}</td>
						<td>{{ Form::text('categorie', null, ["data-column"=>"1", 'id' => 'col1_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Catégorie']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('type', 'Type') }}</td>
						<td>{{ Form::text('type', null, ["data-column"=>"2", 'id' => 'col2_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Type']) }}</td>
					</tr>
				</table>
				{{ Form::button("<i class='entypo-search'></i> Rechercher", ['class'=>'btn btn-success btn-sm btn-icon icon-left', 'id' => 'search']) }}
				{{ Form::button("<i class='entypo-cancel'></i> Effacer", ['id'=> 'clear', 'class'=>'btn btn-primary btn-sm btn-icon icon-left']) }}
			</div>
		</div>

		<table class="table table-bordered table-striped datatable" id="table">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Categorie</th>
					<th>Type</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			@foreach($activities as $activity)
			    <tr>
			    	<td class='search-nom'>{{ $activity->name }}</td>
					<td class='search-cat'>{{ $activity->category->name }}</td>
					<td class='search-type'>{{ $activity->category->type() }}</td>
					<td>

						{!! Formatter::editButton(route('activity.edit', [$activity->id]))!!}



						{!! Formatter::deleteButton($activity->id)!!}

						{!! Formatter::delete(route('activity.delete', $activity->id), $activity->id, "Supprimer une activité", "Voulez-vous vraiment supprimer l'activité " .$activity->name ." ?" ) !!}

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		

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
			    
			    
			    
			    /** Clique sur le type */
	            $(".search-nom").click(function(){
		            var value = $(this).html();
    	            $('#col0_filter').val(value);
    	            search();
	            });
				
	            /** Clique sur la catégorie*/
	            $(".search-cat").click(function(){
		            var value = $(this).html();
		            $('#col1_filter').val(value);
		            search();
		            
	            });

	              /** Clique sur le type*/
	            $(".search-type").click(function(){
		            var value = $(this).html();
		            $('#col2_filter').val(value);
		            search();
		            
	            });
	            
	            /** bouton de recherche  */
	            $("#search").click(function(){
		            search();		            
	            });
	            
	            /** Recherhe */
	            function search() {
	                filterColumn($('#col0_filter').attr('data-column'));
		            filterColumn($('#col1_filter').attr('data-column'));
		            filterColumn($('#col2_filter').attr('data-column'));
	            }
			    
			    /** Vidage des champs */
			    $("#clear").click(function(){
			        $('#col0_filter').val('');
			        $('#col1_filter').val('');
			        $('#col2_filter').val('');
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
		}

           });   
			</script>
@stop
