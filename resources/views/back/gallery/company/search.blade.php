@extends('layouts.back.master')
@section('title', 'Galeries d\'établissements')
@section('content')
{!! Breadcrumbs::render('company.gallery') !!}
<h3>Galeries d'établissements</h3>

		{!! Formatter::addButton( route('company.gallery.add', []) ) !!}

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
						<td>{{ Form::label('cname', 'Entreprise') }}</td>
						<td>{{ Form::text('cname', isset( $request->cid ) ? App\Models\Company::find($request->cid)->name : null, ["data-column"=>"1", 'id' => 'col1_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Entreprise']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('auteur', 'Auteur') }}</td>
						<td>{{ Form::text('auteur', null, ["data-column"=>"6", 'id' => 'col6_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Auteur']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('langue', 'Langue') }}</td>
						<td>{{ Form::text('langue', null, ["data-column"=>"7", 'id' => 'col7_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Langue']) }}</td>
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
					<th>Établissement</th>
					<th>Médias</th>
					<th>Slider<br>établiss.</th>
					<th>Slider<br>accueil</th>
					<th>Galerie<br>accueil</th>
					<th>Carrousel<br>logos</th>
					<th>Slider<br>pub.<br>établiss.</th>
					<th>Slider<br>pub.<br>Dest.</th>
					<th>Slider<br>pub.<br>Liste</th>
					<th>Auteur</th>
					<th>Langue</th>
					<th title="Ajoutée par un admin?">Admin</th>
					<th>Dernière modification</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			
			@foreach($galleries as $gallery)
			    <tr>
			      <td class="search-name cpointer">{{$gallery->gname}}</td>
  					<td>@foreach($gallery->companies->unique() as $company)<div class="item search-cname cpointer" title="{{$company->name}}">{{$company->name}}</div> @endforeach</td>
  					<td align="center">{{ $gallery->medias->count() }}</td>
  					<td><span class="hidden">{{ !is_null($gallery->is_slider) ? '1' : '0' }}</span><input type="checkbox" disabled="" {{ !is_null($gallery->is_slider) ? 'checked=""' : '' }}> </td>
  					<td><span class="hidden">{{ !is_null($gallery->is_homeslider) ? '1' : '0' }}</span><input type="checkbox" disabled="" {{ !is_null($gallery->is_homeslider) ? 'checked=""' : '' }}> </td>
  					<td><span class="hidden">{{ !is_null($gallery->is_home) ? '1' : '0' }}</span><input type="checkbox" disabled="" {{ !is_null($gallery->is_home) ? 'checked=""' : '' }}> </td>
					<td><span class="hidden">{{ !is_null($gallery->is_carousel) ? '1' : '0' }}</span><input type="checkbox" disabled="" {{ !is_null($gallery->is_carousel) ? 'checked=""' : '' }}> </td>
					<td><span class="hidden">{{ !is_null($gallery->is_pubslider) ? '1' : '0' }}</span><input type="checkbox" disabled="" {{ !is_null($gallery->is_pubslider) ? 'checked=""' : '' }}> </td>
					<td><span class="hidden">{{ !is_null($gallery->is_pubslider_destination) ? '1' : '0' }}</span><input type="checkbox" disabled="" {{ !is_null($gallery->is_pubslider_destination) ? 'checked=""' : '' }}> </td>
					<td><span class="hidden">{{ !is_null($gallery->is_pubslider_list) ? '1' : '0' }}</span><input type="checkbox" disabled="" {{ !is_null($gallery->is_pubslider_list) ? 'checked=""' : '' }}> </td>
  					<td class="search-auteur cpointer">{{ $gallery->user->name }}</td>
  					<td class="search-langue cpointer">{{ strtoupper($gallery->locale) }}</td>
  					<td>{{ $gallery->isAdminCreated() ? 'Oui' : 'Non' }}</td>
  					
  					<td>{{Formatter::convertDateTime($gallery->updated_at)}}</td>
  					<td>
  
  						{{--
  						{!! Formatter::previewButton($gallery->id) !!}
  						{!! Formatter::preview($gallery->id, $gallery->content)!!}
  						--}}
  						
  						{!! Formatter::editButton(route('company.gallery.edit', [$gallery->id] )) !!}
  						
              {!! Formatter::button(route('company.gallery.addmedia', [$gallery->id] ), 'primary', 'entypo-picture', 'Médias') !!}
              
  						{!! Formatter::deleteButton($gallery->id)!!}
  						{!! Formatter::delete(route('company.gallery.delete', [$gallery->id]), $gallery->id, "Supprimer une galerie", "Voulez-vous vraiment supprimer la galerie <strong>" .$gallery->name ."</strong> incluant tous les médias associés, dans tout les établissements liés ?" ) !!}
  						
  
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
            $('#col6_filter').val(value);
            search();
        });
        
        /** Clique sur la langue */
        $(".search-langue").click(function(){
          var value = $(this).html();
            $('#col7_filter').val(value);
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
            filterColumn($('#col6_filter').attr('data-column'));
            filterColumn($('#col7_filter').attr('data-column'));
        }
        
        /** Vidage des champs */
        $("#clear").click(function(){
          $('#col0_filter').val('');
          $('#col1_filter').val('');
          $('#col6_filter').val('');
          $('#col7_filter').val('');
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
