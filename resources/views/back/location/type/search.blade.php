@extends('layouts.back.master')
@section('title', 'Type de destinations')
@section('content')
{!! Breadcrumbs::render('location.type.search', $country) !!}
<h3>Hiérarchie des types de destinations</h3>
		{!! Formatter::addButton(route('location.type.add', $country->code))!!}

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
						<td>{{ Form::label('type', 'Type') }}</td>
						<td>{{ Form::text('type', null, ["data-column"=>"1", 'id' => 'col1_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Type']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('parent', 'Parent') }}</td>
						<td>{{ Form::text('parent', null, ["data-column"=>"2", 'id' => 'col2_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Parent']) }}</td>
					</tr>
				</table>
				{{ Form::button("<i class='entypo-search'></i> Rechercher", ['class'=>'btn btn-success btn-sm btn-icon icon-left', 'id' => 'search']) }}
				{{ Form::button("<i class='entypo-cancel'></i> Effacer", ['id'=> 'clear', 'class'=>'btn btn-primary btn-sm btn-icon icon-left']) }}
			</div>
		</div>

		<table class="table table-bordered table-striped datatable" id="table">
			<thead>
				<tr>
					<th>Niveau</th>
					<th>Type</th>
					<th>Parent</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			@foreach($types as $type)
			    <tr>
			    	<td>{{ $type->level }}</td>
					<td class="search-type">{{ $type->name }}</td>
					
					<td class="search-parent">{{ $type->head != null ? $type->head->name : 'Aucun'  }}</td>
					<td>
						
						{!! Formatter::editButton(route('location.type.edit', [$country->code, $type->id]))!!}

						{!! Formatter::deleteButton($type->id)!!}

						{!! Formatter::delete(route('location.type.delete', [$country->code, $type->id]), $type->id, "Supprimer un type de destinations", "Voulez-vous vraiment supprimer le type " .$type->name ." ?" ) !!}

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
			    
			    
			    
			    /** Clique sur le type */
	            $(".search-type").click(function(){
		            var value = $(this).html();
    	            $('#col1_filter').val(value);
    	            search();
	            });
				
	            /** Clique sur le parent*/
	            $(".search-parent").click(function(){
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
	                filterColumn($('#col1_filter').attr('data-column'));
		            filterColumn($('#col2_filter').attr('data-column'));
	            }
			    
			    /** Vidage des champs */
			    $("#clear").click(function(){
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
