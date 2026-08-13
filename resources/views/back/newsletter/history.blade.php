@extends('layouts.back.master')
@section('title', 'Newsletter')
@section('content')
{!! Breadcrumbs::render('newsletter.history') !!}
<h3>Historique des envois</h3>
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
				<td>{{ Form::label('name', 'Nom') }}</td>
				<td>{{ Form::text('name', null, ["data-column"=>"0", 'id' => 'col0_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Nom']) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label('auteur', 'Auteur') }}</td>
				<td>{{ Form::text('auteur', null, ["data-column"=>"1", 'id' => 'col1_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Auteur']) }}</td>
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
			<th>Auteur</th>
			<th>Envoyé le</th>
		</tr>
	</thead>
	<tbody>
	@foreach($sends as $send)
	    <tr>
			<td class='search-name'>{{ $send->newsletter->name }}</td>	
			<td class='search-auteur'>{{ isset($send->user) ? $send->user->name : 'Profil supprimé'}}</td>
			<td >{{ Formatter::convertTimestampToDateTime($send->sended_at) }}</td>
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
			    $('#table').DataTable({sDom: '<"top"l>rt<"bottom"ip><"clear">', "order": [[ 0, "asc" ]]});
			    function filterColumn ( i ) {
			        $('#table').DataTable().column( i ).search(
			            $('#col'+i+'_filter').val()
			        ).draw();
			    }
			    
			    // recherche
			    $('input.column_filter').on( 'keyup click', function () {
			        filterColumn($(this).attr('data-column'));
			    } );
			    
			    
			    
			    /** Clique sur le nom de la news*/
	            $(".search-name").click(function(){
		            var value = $(this).html();
    	            $('#col0_filter').val(value);
    	            search();
	            });

	            /** Clique sur le nom de l'auteur */
	            $(".search-auteur").click(function(){
		            var value = $(this).html();
    	            $('#col1_filter').val(value);
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
	            }
			    
			    /** Vidage des champs */
			    $("#clear").click(function(){
			        $('#col0_filter').val('');
			        $('#col1_filter').val('');
			        search();	            
	            });
           });   
			</script>
@stop
