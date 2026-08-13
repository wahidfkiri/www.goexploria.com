@extends('layouts.back.master')
@section('title', 'Galeries de destination')
@section('content')
{!! Breadcrumbs::render('location.gallery.edit', $gallery) !!}
	<h4>Editer la galerie <strong>{{ $gallery->name }}</strong></h4>
		<div class="row">
			<div class="col-md-12">
						
				<div class="panel-body">
				
				  <div class="details">
				    <label>Destinations liées à cette galerie</label>
				    <br>
				    @if( count_of($locations) == 0 )
				      Aucune
				    @endif
				    
				    @foreach( $locations as $location )
				      {{ $location->name }} ({{ $langList[$location->pivot->language_id] }})<br>
				    @endforeach
				  </div>

					{{ Form::open(array('route' => array('location.gallery.edit.post', $gallery->id), 'method' => 'post', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered')) }}
					
					{!! Form::Label('lang', '* Choisissez une ou plusieurs langues') !!}
          <select class="form-control" name="languages[]" multiple="true" size="3">
            @foreach($langList as $key => $name)
              @if( in_array($key, $language_ids) )
                <option selected value="{{ $key }}">{{ $name }}</option>
              @else
                <option value="{{ $key }}">{{ $name }}</option>
              @endif
            @endforeach
          </select>
          
          <div class="clearfix"></div>
          
          <div style="position: relative;">
            <br>
            <input autocomplete="false" type="text" id="search_location" name="search_location" placeholder="Rechercher dans la liste..." style="margin-bottom: 4px; width: 400px; ">          
            
            <select id="sel_location" class="form-control" name="location_id" style="max-width: 400px;" size="10">
              
            </select>
            
            <select id="sel_locations" multiple="true" class="form-control" name="locations[]" style="overflow-y:auto; max-width: 400px; position: absolute; top:56px; left:410px; border: 0;" size="10">
              @foreach($locations->unique() as $key => $location)
                <option selected="" value="{{ $location->id }}">{{ $location->name }}</option>
              @endforeach
            </select>
          </div>
          
          <div class="clearfix"></div>
          <br>
					<label>Options d'affichage additionnelles</label>
					<br>
					
					{{ Form::checkbox('slider', 1, $gallery->is_slider, ['class' => 'form-control chkboxs', 'id' => 'slider']) }} {{ Form::label('slider', "Afficher dans le slider de la destination?", ['class' => "control-label labels"]) }}
					<br><br>
					
					{{ Form::label('name', "Titre*", ['class' => "control-label"]) }}
	                {{ Form::text('name', $gallery->name, ['class' => 'form-control', 'placeholder' => 'Titre']) }}

	                <br>

					{{-- 
				  {{ Form::label('slug', "Slug*", ['class' => "control-label"]) }}
	                {{ Form::text('slug', $gallery->slug, ['class' => 'form-control', 'min'=>0, 'placeholder' => 'Slug']) }}

	                <br>
          

					{{ Form::label('content', "Description de la galerie", ['class' => "control-label"]) }}
	                {!! Form::textarea('content', $gallery->content, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) !!}

	                <br>
          --}}
					{{ Form::submit('Modifier') }}
					
					&nbsp;&nbsp; <a href="{{ route('location.gallery.search') }}">Annuler</a>
					
	                {{ Form::close() }}
				
				</div>
			
			</div>
		</div>

@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\EditGalleryPostRequest', '#editForm'); !!}

<script>
jQuery(document).ready(function(){
  
  $('#search_location').focus(function() {
     $(this).select();
  });
  $('#sel_locations').blur(function() {
     $(this).find('option').prop('selected', true);
  });
  
  $('body').on('keyup', '#search_location', function(){
  //$('#search_location').keyup(function(){
    if (this.value != '' && this.value.length > 2) {
      
      // Loading...
      $('#sel_location').html('<option>Recherche en cours...</option>');
      
      $.ajax({
          type: "POST",
          url : "{{ route('ajax.getlocationsbysearch') }}",
          headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
          data : { search: this.value },
          //dataType: 'json',
          success : function(data)
          {
              var options = '';
              for(i=0; i<data.length; i++) {
                options += '<option value="'+ data[i].id +'">'+ data[i].name + (data[i].tname == null ? '' : ' ( ' + data[i].tname + ' )') +'</option>';
              }                  
              
              if(data.length > 0)
              {
                $('#sel_location').html(options);
              } else {
              	$('#sel_location').html('<option>Aucun établissement trouvé...</option>');
              }
          },
          error : function(data)
          {
              var errors = $.parseJSON(data.responseText);
              //console.log(errors);
              
          }
  
      },"json");
      
    } else {
      if (this.value.length < 3){
        $('#sel_location').html('<option>3 caractères minimum pour recherche...</option>');
      } else {
      	$('#sel_location').html('<option>Aucun établissement correspondant...</option>');
      }
    }
  });
  
  $("#sel_location,#sel_locations").on("dblclick", function(e) { 
      
      var ID = $(e.target).parent().attr("ID");
      var moveFrom = '#'+ID;
      var moveTo = ID == "sel_location" ? "#sel_locations" : "#sel_location";
      var selectData = $(moveFrom + " :selected").toArray();
      $(moveTo).append(selectData);
      selectData.remove;
      
      $('#search_location').focus();
      $('#sel_locations option').prop('selected', true);
      
  });
  
  
  
});

</script>
    
<style type="text/css">
.details {
  margin-bottom: 10px;
  padding: 10px;
  border: 1px solid #cc0000;
  background-color: #f7f7f7;
  width: auto;
}

.chkboxs{
  display: inline-block;
  width: auto;
  vertical-align:middle; 
}
.labels{
  vertical-align:middle; 
}

</style>
    
@stop