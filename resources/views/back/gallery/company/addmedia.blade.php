@extends('layouts.back.master')
@section('title', 'Galeries d\'établissements')
@section('content')
{!! Breadcrumbs::render('company.gallery.addmedia', $gallery->id) !!}
<h1>Ajout de médias à une galerie ({{ $gallery->name }})</h1>
<div class="row">
	<div class="col-md-12">

		<div class="panel-body">
      <div class="col-md-4">
        <h2>Ajouter des photos</h2>
        <div class="details">
          <label title="max_file_uploads">Nb. de fichier maximum téléchargé en même temps</label>: <?php echo ini_get('max_file_uploads'); ?>
          <br>
          <label title="upload_max_filesize">Taille par fichier maximum</label>: <?php echo ini_get('upload_max_filesize'); ?>
          <br>
          <label title="post_max_size">Taille totale maximum</label>: <?php echo ini_get('post_max_size'); ?>
        </div>

        {{ Form::open(array('route' => array('company.gallery.addmedia.post'), 'method' => 'POST', 'files'=>true, 'id' => 'uploadForm', 'autocomplete' => 'off', 'class' => 'form-horizontal form-groups-bordered')) }}
          {{ Form::hidden('gallery_id', $gallery->id) }}

          <div class="secure"><label>Sélectionnez les médias à associer à cette galerie</label></div>
          <div class="control-group">
            <div class="controls">
              {{ Form::file('medias[]', array('multiple'=>true)) }}
            	<p class="errors">{!! $errors->first('images') !!}</p>
            	@if(Session::has('error'))
            	<p class="errors">{!! Session::get('error') !!}</p>
            	@endif
              {{ Form::checkbox( 'must_resize', 'true', true ) }} {{ Form::label( 'must_resize', 'Redimensionner' ) }} <br>
              {{ Form::label( 'width', 'Largeur') }} {{ Form::number( 'width', $dims[0] ) }} <br>
              {{ Form::label( 'height', 'Hauteur') }} {{ Form::number( 'height', $dims[1] ) }} <br>
              <br>
            </div>
          </div>

          <input type="button" name="upload" id="upload" value="Envoyer">
          <div class="progress none" style="display: none; margin-top: 10px;">
              <img src="{!! asset('images/uploading.gif') !!}" style="width:auto;">
          </div>

          <div id="preview"></div>
        </form>
      </div><!--end 1st column -->

      <div class="col-md-4">
        <h2>Liez un vidéos</h2>
        {{ Form::open(array('route' => array('company.gallery.addvideo.post'), 'method' => 'POST', 'id' => 'uploadForm_video', 'autocomplete' => 'off', 'class' => 'form-horizontal form-groups-bordered')) }}
          <div class="form-group">
            {{ Form::hidden('gallery_id', $gallery->id) }}
            <label for="url">URL du vidéo</label>
            <input type="url" class="form-control" name="url">
          </div>


          <input type="submit" name="addVideo" id="addVideo" value="Envoyer">

      </div><!-- end 2nd column -->

      <div class="clearfix"></div>
      <br><br>
      {!! link_to_route('company.gallery.edit', 'Retour à la galerie', [$gallery->id], ['class' => 'btn btn-default btn-sm', 'title' => 'Retour']) !!}
      &nbsp;&nbsp;
      {!! link_to_route('company.gallery.search', 'Liste des galeries', [], ['class' => 'btn btn-default btn-sm', 'title' => 'Retour']) !!}
      <br><br>

      {{ Form::open(array('route' => array('company.gallery.editmedia.post'), 'method' => 'POST', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered')) }}

      <div id="medias">
        <label>Médias de la galerie</label>
        <br>

        @if( count_of($medias) == 0 ) Aucun média trouvé. @endif
        <script>
        var med = {!! json_encode($medias, JSON_HEX_QUOT | JSON_PRETTY_PRINT) !!};


        </script>
        @foreach( $medias as $key => $media )
          <div class="container" ng-controller="GalleryBackCtrl">
            @if ($media->photo)
              <div class="img_container"><img width="200" src="{{ URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) }}"></div>
            @else
              @if (App\Helpers\Formatter::getVideoType($media->slug) == 'youtube')
                  <div class="img_container"><img width="200" src="{{ App\Helpers\Formatter::getYoutubeMiniature($media->slug) }}"></div>
              @elseif (App\Helpers\Formatter::getVideoType($media->slug) == 'vimeo')
                  <div class="img_container"><img width="200" src="{{ App\Helpers\Formatter::getVimeoMiniature($media->slug) }}"></div>
              @endif
            @endif
            <div class="content">
              {{ Form::text('name', $media->name, ['class' => 'form-control input-sm', 'min'=>0, 'placeholder' => 'Titre', 'autocomplete' => 'off', 'title' => 'Nom']) }}
              {{ Form::text('target', $media->target, ['class' => 'form-control input-sm', 'min'=>0, 'placeholder' => 'http://', 'autocomplete' => 'off', 'title' => 'Lien']) }}
              @if ($media->photo)
                {{ Form::text('content', $media->content, ['class' => 'form-control input-sm', 'min'=>0, 'placeholder' => 'Auteur', 'autocomplete' => 'off', 'title' => 'Auteur']) }}
              @endif
                {{ Form::text('rank', $media->rank, ['class' => 'form-control input-sm', 'min'=>0, 'placeholder' => 'Ordre', 'autocomplete' => 'off', 'title' => 'Ordre']) }}
                {{ Form::text('code', $media->code, ['class' => 'form-control input-sm', 'min'=>0, 'placeholder' => 'Code', 'autocomplete' => 'off', 'title' => 'Code']) }}



              Attributs: <button type="button" class="btn btn-default btn_add_attr">Ajouter</button><br>
              <div class="attrs">

                @foreach($media->attrs()->get() as $attr)
                  <div class="attr">
                    {{ Form::text('attr_name', $attr->attr, ['class' => 'form-control input-sm attr_name', 'placeholder' => 'Attribut', 'autocomplete' => 'off', 'title' => 'Attribut']) }}
                    {{ Form::text('attr_value', $attr->value, ['class' => 'form-control input-sm attr_value', 'placeholder' => 'Valeur', 'autocomplete' => 'off', 'title' => 'Valeur']) }}<span class="glyphicon glyphicon-remove del_attr"></span>
                  </div>
                @endforeach

              </div>
              <input type="button" name="save" item-id="{{ $media->id }}" value="Sauvegarder" class="btn_save ">
              {!! Formatter::deleteButton($media->id) !!}
  						{!! Formatter::delete(route('company.gallery.deletemedia', [$media->id]), $media->id, "Supprimer un media", "Voulez-vous vraiment supprimer ce média <strong>" .$media->name ."</strong> (ID: ".$media->id.") ?" ) !!}
            </div>
          </div>
        @endforeach
      </div>

  </div>
</div>
</div>
@stop
@section('js')
<script src="{!! asset('js/back/jquery.form.js') !!}"></script>
<script>
jQuery(document).ready(function(){

  $('body').on('change', 'input[type=text]', function(e){
    $(this).parent().find('.btn_save').val('Sauvegarder').css({'font-weight':'inherit', 'color':'inherit'});
  });

  $('body').on('click', '.btn_save', function(e){
    $(this).val('Sauvegarder').css({'font-weight':'inherit', 'color':'inherit'});

    var btn = this;
    var parent = this.parentNode;
    $.ajax({
        type: "POST",
        url : "{{ route('ajax.saveeditmedia') }}",
        headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
        data : {
          id:         $(this).attr('item-id'),
          gallery_id: {{ $gallery->id }},
          name:       $(parent).find('input[name=name]').val(),
          target:     $(parent).find('input[name=target]').val(),
          content:     $(parent).find('input[name=content]').val(),
            rank:       $(parent).find('input[name=rank]').val(),
            code:       $(parent).find('input[name=code]').val(),
          attrs :     $(this).prev(".attrs")
            .find('input')
            .toArray()
            .map( function(input) { return input.value })
            .reduce( function(tab, val) {
              var len = tab.length;
              if(len == 0 || tab[len-1].value) {
                tab.push({attr:val})
              } else {
                tab[len-1].value = val;
              }
              return tab;
          },[]),
        },
        //dataType: 'json',
        success : function(data)
        {
          $(btn).val('Sauvegardé!').css({'font-weight':'bold', 'color':'green'});
        },
        error : function(data)
        {
          var errors = $.parseJSON(data.responseText);
          //console.log(errors);
          $(btn).val('Erreur!').css({'font-weight':'bold', 'color':'#cc0000'});
        }
    },"json");
  });

  $('body').on('click', ".btn_add_attr", function() {
    console.log("btn_add_attr")
    $(this).nextAll(".attrs").append(
      '<div class="attr">'
        + '<input type="text" class="form-control input-sm attr_name" name="attr_name" placeholder="Attribut">'
        + '<input type="text" class="form-control input-sm attr_value" name="attr_value" placeholder="Valeur">'
        + '<span class="glyphicon glyphicon-remove del_attr"></span>'
    + "</div>")
  });

  $('body').on('click', ".del_attr", function() {
    $(this).parent('.attr').remove();
  })

  /************************* SUPPRESSION ************************/
  /**************************************************************/

 	   $(".delete").click(function(){
  	  var value = $(this).attr('data');
  	  console.log('Delete: ' + value);
	    $('#modal-delete-'+value).modal('show');
  		return false;
  	});


  $('body').on('click', '#upload', function(){
    $('#uploadForm').ajaxForm({
        target:'#preview',
        beforeSubmit:function(e){
            $('.progress').show();
        },
        success:function(e){
            $('.progress').hide();
            document.location.reload(true);
        },
        error:function(e){
          var errors = $.parseJSON(e.responseText);
          //console.log('Error:'+errors);
        }
    }).submit();
  });




});

</script>
@stop
@section('more_css')
  <style type="text/css">
    #preview .container {
      margin: 5px;
      display: inline-block;
      width: auto;
      background-color: #f7f7f7;
      padding: 5px;
      height: 130px;
      width: 200px;
      float: left;
    }
    #preview img {
      width: 100%;
      height: auto;
      max-height: 130px;
      max-width: 200px;
    }
    #medias .container {
      margin: 5px;
      display: inline-block;
      width: auto;
      background-color: #f7f7f7;
      padding: 5px;
      min-height: 130px;
      width: 200px;
      float: left;
    }
    #medias .img_container {
      height: 125px;
      overflow: hidden;
    }
    #medias img {

      max-height: 130px;
      max-width: 200px;
    }
    #medias .container .content {
      margin: 5px;
      width: auto;
      border: 1px solid #fff;
    }
    #medias .container .content input {
      margin-top: 2px;
      margin-bottom: 2px;
    }
    #medias .container .content input[type=button] {
      margin-top: 5px;
    }

    .details {
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid #cc0000;
      background-color: #f7f7f7;
      width: auto;
    }
    .attr > .form-control {
      display: inline;
      width: unset;
    }
  </style>
@stop
