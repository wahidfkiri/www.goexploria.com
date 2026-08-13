@extends('layouts.back.master')
@section('title', 'Galeries d\'établissements')
@section('content')
{!! Breadcrumbs::render('company.gallery.edit', $gallery) !!}
	<h4>Editer la galerie <strong>{{ $gallery->name }}</strong></h4>
		<div class="row">
			<div class="col-md-12">

				<div class="panel-body">

				  <div class="details">
				    <label>Établissements liés à cette galerie</label>
				    <br>
				    @if( count_of($companies) == 0 )
				      Aucune
				    @endif

				    @foreach( $companies as $company )
				      {{ $company->name }} ({{ $langList[$company->pivot->language_id] }})<br>
				    @endforeach
				  </div>

					{{ Form::open(array('route' => array('company.gallery.edit.post', $gallery->id), 'method' => 'post', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered', 'autocomplete' => 'off')) }}

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
              @foreach($companies->unique() as $key => $company)
                <option selected="" value="{{ $company->id }}">{{ $company->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="clearfix"></div>

					<br>
					<label>Options d'affichage additionnelles</label>
					<br>
					{{ Form::text('slider', $gallery->is_slider, ['class' => 'form-control input-sm col-xs-2 input-digit-sm', 'placeholder' => 'Ordre']) }} &nbsp; <span class="help-block inline-block">Afficher dans le slider de l'établissement?</span>

					<br>
					{{ Form::text('homeslider', $gallery->is_homeslider, ['class' => 'form-control input-sm col-xs-2 input-digit-sm', 'placeholder' => 'Ordre']) }} &nbsp; <span class="help-block inline-block">Afficher dans le slider de la page d'accueil?</span>

          <br>
          {{ Form::text('home', $gallery->is_home, ['class' => 'form-control input-sm col-xs-2 input-digit-sm', 'placeholder' => 'Ordre']) }} &nbsp; <span class="help-block inline-block">Afficher comme galerie sur la page d'accueil?</span>

          <br>
          {{ Form::text('carousel', $gallery->is_carousel, ['class' => 'form-control input-sm col-xs-2 input-digit-sm', 'placeholder' => 'Ordre']) }} &nbsp; <span class="help-block inline-block">Afficher comme carrousel de logos?</span>

                    <br>
                    {{ Form::text('pubslider', $gallery->is_pubslider, ['class' => 'form-control input-sm col-xs-2 input-digit-sm', 'placeholder' => 'Ordre']) }} &nbsp; <span class="help-block inline-block">Afficher dans le slider publicitaire (établissement)?</span>
                    <br>
                    {{ Form::text('pubslider_destination', $gallery->is_pubslider_destination, ['class' => 'form-control input-sm col-xs-2 input-digit-sm', 'placeholder' => 'Ordre']) }} &nbsp; <span class="help-block inline-block">Afficher dans le slider publicitaire (destination)?</span>
                    <br>
                    {{ Form::text('pubslider_list', $gallery->is_pubslider_list, ['class' => 'form-control input-sm col-xs-2 input-digit-sm', 'placeholder' => 'Ordre']) }} &nbsp; <span class="help-block inline-block">Afficher dans le slider publicitaire (Liste)?</span>

					<br>
					<span class="help-block">Ordre doit inclure un nombre en <b>-100 à 100</b> ou <b>vide</b> pour désactiver.</span>

					<br>

          <label>Page parent : </label>
          <br>
          {{ Form::select('page',$pages, $parent, ['placeholder' => "Choisir la page parent ..."])  }}
          <br>



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

					&nbsp;&nbsp; <a href="{{ route('company.gallery.search') }}">Annuler</a>

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
          url : "{{ route('ajax.getcompaniesbysearch') }}",
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
