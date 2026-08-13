@extends('layouts.back.master')
@section('title', 'Galeries de pays')
@section('content')
{!! Breadcrumbs::render('country.gallery') !!}
<h3>Galeries de pays</h3>

		{!! Formatter::addButton( route('country.gallery.add', []) ) !!}

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
						<td>{{ Form::label('name', 'Titre de galerie') }}</td>
						<td>{{ Form::text('name', null, ["data-column"=>"0", 'id' => 'col0_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Titre']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('cname', 'Pays') }}</td>
						<td>{{ Form::text('cname', isset( $request->cid ) ? App\Models\Country::find($request->cid)->name : null, ["data-column"=>"1", 'id' => 'col1_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Entreprise']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('auteur', 'Auteur') }}</td>
						<td>{{ Form::text('auteur', null, ["data-column"=>"3", 'id' => 'col3_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Auteur']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('langue', 'Langue') }}</td>
						<td>{{ Form::text('langue', 'FR', ["data-column"=>"4", 'id' => 'col4_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Langue']) }}</td>
					</tr>
				</table>

				{{ Form::button("<i class='entypo-search'></i> Rechercher", ['class'=>'btn btn-success btn-sm btn-icon icon-left', 'id' => 'search']) }}
				{{ Form::button("<i class='entypo-cancel'></i> Effacer", ['id'=> 'clear', 'class'=>'btn btn-primary btn-sm btn-icon icon-left']) }}
			</div>
		</div>

		<table class="table table-bordered table-striped datatable" id="table">
			<thead>
				<tr>
					<th>Galerie</th>
					<th>Pays</th>
					<th>Médias</th>
					
					
					
					<th>Auteur</th>
					<th>Langue</th>
					<th>Admin</th>
					<th>Dernière modification</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			
			@foreach($galleries as $gallery)
			    <tr>
			      <td class="search-name cpointer">{{ $gallery->name }}</td>
  					<td>@foreach($gallery->countries->unique() as $country)<div class="item search-cname cpointer" title="{{$country->name}}">{{$country->name}}</div> @endforeach</td>
  					<td align="center">{{ $gallery->medias->count() }}</td>
  					
  					
  					
  					<td class="search-auteur cpointer">{{ $gallery->user->name }}</td>
  					<td class="search-langue cpointer">{{ strtoupper($gallery->locale) }}</td>
  					<td>{{ $gallery->isAdminCreated() ? 'Oui' : 'Non' }}</td>
  					
  					<td>{{Formatter::convertDateTime($gallery->updated_at)}}</td>
  					<td>
  
  						{{--
  						{!! Formatter::previewButton($gallery->id) !!}
  						{!! Formatter::preview($gallery->id, $gallery->content)!!}
  						--}}
  						
  						{!! Formatter::editButton(route('country.gallery.edit', [$gallery->id] )) !!}
  						
              {!! Formatter::button(route('country.gallery.addmedia', [$gallery->id] ), 'primary', 'entypo-picture', 'Médias') !!}
              
  						{!! Formatter::deleteButton($gallery->id)!!}
  						{!! Formatter::delete(route('country.gallery.delete', [$gallery->id]), $gallery->id, "Supprimer une galerie", "Voulez-vous vraiment supprimer la galerie <strong>" .$gallery->name ."</strong> incluant tous les médias associés, dans tout les pays liés ?" ) !!}
  						
  
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
		    $('#table').DataTable(
		    {
		    	sDom: '<"top"l>rt<"bottom"ip><"clear">',
		    	"order": [[ 0, "asc" ]],
		    	"drawCallback": function( settings ) 
		    	{
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
		    });
			    
        /** Clique sur le nom */
        $(".search-name").click(function(){
          var value = $(this).html();
            $('#col0_filter').val(value);
            search();
        });
        
        /** Clique sur le nom d'entreprise */
        $(".search-cname").click(function(){
          var value = $(this).html();
            $('#col1_filter').val(value);
            search();
        });
        
        /** Clique sur le nom d'auteur */
        $(".search-auteur").click(function(){
          var value = $(this).html();
            $('#col3_filter').val(value);
            search();
        });
        
        /** Clique sur la langue */
        $(".search-langue").click(function(){
          var value = $(this).html();
            $('#col4_filter').val(value);
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
        
        /*function searchStatut(src) {
           var data = src.val() >= 0 ? src.find("option:selected").text() : '';
        
            $('#col2_filter').val(data);
            search();
        }
        */
        
        /** bouton de recherche  */
        $("#search").click(function(){
          search();		            
        });
        
        /** Recherhe */
        function search() {
            filterColumn($('#col0_filter').attr('data-column'));
            filterColumn($('#col1_filter').attr('data-column'));
            filterColumn($('#col3_filter').attr('data-column'));
            filterColumn($('#col4_filter').attr('data-column'));
        }
        
        /** Vidage des champs */
        $("#clear").click(function(){
          $('#col0_filter').val('');
          $('#col1_filter').val('');
          $('#col3_filter').val('');
          $('#col4_filter').val('');
          search();	            
        });
			    
			  search(); // On page load
			  
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
