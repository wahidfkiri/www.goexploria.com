@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
{!! Breadcrumbs::render('company.edit.settings', $company) !!}
@stop
@section('left-menu')
@include('back.company.menu')
@stop

@section('right-content')
<h1>{{$company->name}} - Configurations</h1>
<h2>Adresses externes</h2>
{!! Form::open(array('route' => array('company.edit.settings.post', $company->id), 'method' => 'post','name' => 'companyForm', 'id' => 'editForm')) !!}
<div id="error_msg_url" class="alert alert-danger" style="display:none" role="alert"></div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
  <div class="col-lg-6">
    <div class="input-group">
      <input type="text" class="form-control" name="new_domain" placeholder="mon-domaine.com">
      <span class="input-group-btn">
        <button id="addDomain"class="btn btn-default" type="button">Ajouter</button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
<div class="row">
  <div class="col-lg-6">
    <table id="externalSites">
      @foreach($company->getExternalDomains() as $key => $site)
      <tr>
        <td class="remove_value">{{ $site->value }}</td>
        <td class="domain remove_btn"><span class="glyphicon glyphicon-remove "></span></td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
{!! Form::close() !!}

<br>

<div class="row">
  <div class="col-lg-6">
    <h2>Thème du site</h2>
    <div id="error_msg_selectTheme" class="alert alert-danger" style="display:none" role="alert"></div>
    {!! Form::open(array('route' => array('company.edit.settings.post', $company->id), 'method' => 'post','name' => 'SelectThemeForm', 'id' => 'SelectThemeForm')) !!}
    <div class="col-lg-16">
      <div class="input-group">
        <select id="SelectTheme" required class="form-control" name="theme">
          @foreach($themes as $theme)
          <option value="{{$theme}}" @if($curr_theme == $theme) selected="selected" @endif>{{$theme}}</option>
          @endforeach
        </select>
        <span class="input-group-btn">
          <button id="SelectTheme_btn"class="btn btn-primary" type="button">Choisir</button>
          <button id="DownloadTheme_btn"class="btn btn-default" type="button">Télécharger</button>
        </span>
      </div>
    </div>
    {!! Form::close() !!}
  </div>

  <div class="col-lg-4">
    <h2>Téléverser un thème</h2>
    {{ Form::open([ 'route' => [ 'company.edit.settings.uploadtheme', $company->id ], 'files' => true]) }}
    <input type="file" accept=".zip" name="zipfile"></input>
    <input type="submit" name="submit"></input>
    {{ Form::close() }}
  </div>
</div>


<div class="row">
  <div class="col-lg-6">
    <h2>Fichier CSS Supplémentaire</h2>
    <div id="error_msg_css" class="alert alert-danger" style="display:none" role="alert"></div>
    {!! Form::open(array('route' => array('company.edit.settings.post', $company->id), 'method' => 'post','name' => 'companyForm', 'id' => 'cssFileForm')) !!}
    <div class="row">
      <div class="col-lg-12">
        <div class="input-group">
          <select id="SelectCss" required class="form-control" name="fichier_css">
            <option value="aucun" @if ( ! isset( $configs["fichier_css"] ) ) selected="selected" @endif> - Aucun - </option>

            @foreach($cssFiles as $file)
              <option value="{{$file}}" @if( isset( $configs["fichier_css"] ) && $configs["fichier_css"] == $file)  selected="selected" @endif>{{$file}}</option>
            @endforeach

          </select>

          <span class="input-group-btn">
            <button id="addCssFilename"class="btn btn-primary" type="button">Choisir</button>
          </span>
        </div><!-- /input-group -->
      </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
    {!! Form::close() !!}
  </div>
  <div class="col-lg-4">
    <h2>Téléverser un fichier css</h2>
    {{ Form::open([ 'route' => [ 'company.edit.settings.uploadsitecss', $company->id ], 'files' => true]) }}
    <input type="file" accept=".css" name="cssfile"></input>
    <input type="submit" name="submit"></input>
    {{ Form::close() }}
  </div>
</div>

<br><br>

<div class="row">
  <div class="col-lg-12">
    <h2>Dupliquer un theme existant</h2>
    <div id="error_msg_cloneTheme" class="alert alert-danger" style="display:none" role="alert"></div>
    {!! Form::open(array('route' => array('company.edit.settings.post', $company->id), 'method' => 'post','name' => 'cloneThemeForm', 'id' => 'cloneThemeForm')) !!}
    <div class="row">
      <div class="col-lg-3">
        <select id="theme_parent" required class="form-control" name="theme_parent">
          @foreach($themes as $theme)
          <option value="{{$theme}}" @if($curr_theme == $theme) selected="selected" @endif>{{$theme}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          <input type="text" class="form-control" name="theme_name" required placeholder="nom du nouveau theme">
          <span class="input-group-btn">
            <button id="cloneTheme_btn"class="btn btn-primary" type="button">Cloner</button>
          </span>
        </div>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>


<div class="row">
  <div class="col-lg-12">
    <h2>Personnalisation</h2>
    <div id="error_msg_cloneTheme" class="alert alert-danger" style="display:none" role="alert"></div>
    {!! Form::open(array('route' => array('company.edit.settings.post', $company->id), 'method' => 'post','name' => 'cloneThemeForm', 'id' => 'cloneThemeForm')) !!}
    <div class="row">
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('topcolor', 'Barre du haut - Couleur de l\'arrière-plan', ['class' => 'control-label']) !!}
          {!! Form::text('topcolor', old('topcolor', $company->topcolor), ['class' => 'form-control colorpicker']) !!}
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_top_text_color', 'Barre du haut - Couleur du texte', ['class' => 'control-label']) !!}
          {!! Form::text('config_top_text_color', old('config_top_text_color', $company->config_top_text_color), ['class' => 'form-control colorpicker']) !!}
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_top_link_color', 'Barre du haut - Couleur des liens', ['class' => 'control-label']) !!}
          {!! Form::text('config_top_link_color', old('config_top_link_color', $company->config_top_link_color), ['class' => 'form-control colorpicker']) !!}
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_top_link_hover_color', 'Barre du haut - Couleur des liens (hover)', ['class' => 'control-label']) !!}
          {!! Form::text('config_top_link_hover_color', old('config_top_link_hover_color', $company->config_top_link_hover_color), ['class' => 'form-control colorpicker']) !!}
        </div>
      </div>
    </div>
    <br>

    <div class="row">
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_show_top_title', 'Barre du haut - Montrer le titre?', ['class' => 'control-label']) !!}<br>
          {!! Form::checkbox('config_show_top_title', old('config_show_top_title', $company->config_show_top_title), ($company->config_show_top_title || is_null($company->config_show_top_title)) ? true : false ) !!}
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_show_top_phone', 'Barre du haut - Montrer le téléphone?', ['class' => 'control-label']) !!}<br>
          {!! Form::checkbox('config_show_top_phone', old('config_show_top_phone', $company->config_show_top_phone), ($company->config_show_top_phone || is_null($company->config_show_top_phone)) ? true : false ) !!}
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_show_top_email', 'Barre du haut - Montrer le courriel?', ['class' => 'control-label']) !!}<br>
          {!! Form::checkbox('config_show_top_email', old('config_show_top_email', $company->config_show_top_email), ($company->config_show_top_email || is_null($company->config_show_top_email)) ? true : false ) !!}
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_top_text', 'Barre du haut - Texte supplémentaire', ['class' => 'control-label']) !!}
          {!! Form::text('config_top_text', old('config_top_text', $company->config_top_text), ['class' => 'form-control']) !!}
        </div>
      </div>
    </div>
    <br>

    <div class="row">
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_menu_back_color', 'Menu du haut - Couleur de l\'arrière-plan', ['class' => 'control-label']) !!}
          {!! Form::text('config_menu_back_color', old('config_menu_back_color', $company->config_menu_back_color), ['class' => 'form-control colorpicker']) !!}
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_menu_link_color', 'Menu du haut - Couleur des liens', ['class' => 'control-label']) !!}
          {!! Form::text('config_menu_link_color', old('config_menu_link_color', $company->config_menu_link_color), ['class' => 'form-control colorpicker']) !!}
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_menu_link_hover_color', 'Menu du haut - Couleur des liens (hover)', ['class' => 'control-label']) !!}
          {!! Form::text('config_menu_link_hover_color', old('config_menu_link_hover_color', $company->config_menu_link_hover_color), ['class' => 'form-control colorpicker']) !!}
        </div>
      </div>
    </div>
    <br>

    <div class="row">
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_menu_position', 'Menu du haut - Emplacement du menu', ['class' => 'control-label']) !!}
          <select id="config_menu_position" required class="form-control" name="config_menu_position">
            <option value="avant" @if($company->config_menu_position == 'avant') selected="selected" @endif>Avant l'entête</option>
            <option value="apres" @if($company->config_menu_position == 'apres') selected="selected" @endif>Après l'entête</option>
          </select>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_menu_min_height', 'Menu du haut - Hauteur minimale (px)', ['class' => 'control-label']) !!}
          {!! Form::number('config_menu_min_height', old('config_menu_min_height', $company->config_menu_min_height), ['class' => 'form-control']) !!}
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_menu_has_logo', 'Menu du haut - Afficher le logo?', ['class' => 'control-label']) !!}<br>
          {!! Form::checkbox('config_menu_has_logo', old('config_menu_has_logo', $company->config_menu_has_logo), ($company->config_menu_has_logo || is_null($company->config_menu_has_logo)) ? true : false ) !!}
        </div>
      </div>
      <div class="col-lg-3" style="visibility: hidden;">
        <div class="input-group">
          {!! Form::label('config_menu_logo_position', 'Menu du haut - Emplacement du logo', ['class' => 'control-label']) !!}
          <select id="config_menu_logo_position" required class="form-control" name="config_menu_logo_position">
            <option value="left" @if($company->config_menu_logo_position == 'left') selected="selected" @endif>Gauche</option>
            <option value="center" @if($company->config_menu_logo_position == 'center') selected="selected" @endif>Centre</option>
          </select>
        </div>
      </div>
    </div>
    <br>

    <div class="row">
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_footer_text_color', 'Pied de page - Couleur du texte', ['class' => 'control-label']) !!}
          {!! Form::text('config_footer_text_color', old('config_footer_text_color', $company->config_footer_text_color), ['class' => 'form-control colorpicker']) !!}
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_footer_link_color', 'Pied de page - Couleur des liens', ['class' => 'control-label']) !!}
          {!! Form::text('config_footer_link_color', old('config_footer_link_color', $company->config_footer_link_color), ['class' => 'form-control colorpicker']) !!}
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_footer_link_hover_color', 'Pied de page - Couleur des liens (hover)', ['class' => 'control-label']) !!}
          {!! Form::text('config_footer_link_hover_color', old('config_footer_link_hover_color', $company->config_footer_link_hover_color), ['class' => 'form-control colorpicker']) !!}
        </div>
      </div>
    </div>
    <br>

    <div class="row">
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_hide_contact', 'Cacher la page de contact?', ['class' => 'control-label']) !!}<br>
          {!! Form::checkbox('config_hide_contact', old('config_hide_contact', $company->config_hide_contact), ($company->config_hide_contact && !is_null($company->config_hide_contact)) ? true : false ) !!}
          <!--
          {!! Form::label('config_custom_css', 'CSS Personnalisés', ['class' => 'control-label']) !!}
          {!! Form::textarea('config_custom_css', old('config_custom_css', $company->config_custom_css), ['class' => 'form-control']) !!}
          -->
        </div>
      </div>
      <div class="col-lg-3">
        <div class="input-group">
          {!! Form::label('config_show_commands', 'Afficher la section des commandes?', ['class' => 'control-label']) !!}<br>
          {!! Form::checkbox('config_show_commands', old('config_show_commands', $company->config_show_commands), ($company->config_show_commands && !is_null($company->config_show_commands)) ? true : false ) !!}
          <!--
          {!! Form::label('config_custom_css', 'CSS Personnalisés', ['class' => 'control-label']) !!}
          {!! Form::textarea('config_custom_css', old('config_custom_css', $company->config_custom_css), ['class' => 'form-control']) !!}
          -->
        </div>
      </div>
    </div>
    <br>

    <div>
      <button id="config_btn"class="btn btn-primary" type="button">Sauvegarder</button>
    </div>
    {!! Form::close() !!}
  </div>

  <div class="col-lg-4"></div>
</div>

@stop

@section('js')

<script><!-- Add exernal sites -->
$("#addDomain").click(function() {
  var val = $("#editForm input[name='new_domain']").val();
  var out;
  var that = this;
  if(!val.match(/http:\/\//)) {
    out = "http://" + val;
  } else {
    out = val;
    val = val.replace(/http:\/\//,'');
  }
  $.ajax({
    method: "POST",
    url: "configs/ajax",
    data : {
      new_domain: out
    }
  })
  .done(function(msg) {
    if(msg === "OK") {
      $("#externalSites").append("<tr>" +
      '<td class="remove_value">'+ val +'</td>' +
      '<td class="domain remove_btn"><span class="glyphicon glyphicon-remove "></span></td>' +
      '</tr>');
      $("#editForm input[name='new_domain']").val('');
    }
  })
  .fail(function(i) {
    $("#error_msg_url").text("URL invalide.").show();
  })
})

$(document).on("click", ".domain.remove_btn span", function() {
  var that = this;
  $.ajax({
    method: "POST",
    url: "configs/ajax",
    data : {
      remove_domain: $(this).parent().prev().text()
    }
  }).done(function(msg) {
    if(msg === "OK") {
      $(that).parent().parent().remove();
    }
  })
})
</script>

<script><!-- Add Fichier css -->
$("#addCssFilename").click(function() {
  var nom_fichier = $("#SelectCss").val();
  var out;
  var that = this;
  if(!nom_fichier.match(/^[a-zA-Z0-9\-_.]*\.css$/) && nom_fichier != 'aucun') {
    return $("#error_msg").val("mauvais nom de fichier. ");
  }

  $.ajax({
    method: "POST",
    url: "configs/ajax",
    data : {
      new_fileCss: nom_fichier,
    }
  })
  .done(function(msg) {
    if(msg === "OK") {
      toastr.success('', "Succès");
    } else {
      console.error(msg);
    }
  })
  .fail(function(msg) {
    $("#error_msg_css").text(msg).show();
  })
})
</script>

<script>
  $(document).on('click', "#config_btn", function() {
    var that = this;

    $.ajax({
      method: "POST",
      url: "configs/ajax",
      data : {
        configSaveBtn: {
          topcolor : $("input[name=topcolor]").val(),
          config_top_text_color : $("input[name=config_top_text_color]").val(),
          config_top_link_color : $("input[name=config_top_link_color]").val(),
          config_top_link_hover_color : $("input[name=config_top_link_hover_color]").val(),
          config_show_top_title : ($("input[name=config_show_top_title]").prop('checked')),
          config_show_top_phone : $("input[name=config_show_top_phone]").prop('checked'),
          config_show_top_email : $("input[name=config_show_top_email]").prop('checked'),
          config_top_text : $("input[name=config_top_text]").val(),
          config_menu_back_color : $("input[name=config_menu_back_color]").val(),
          config_menu_link_color : $("input[name=config_menu_link_color]").val(),
          config_menu_link_hover_color : $("input[name=config_menu_link_hover_color]").val(),
          config_footer_text_color : $("input[name=config_footer_text_color]").val(),
          config_footer_link_color : $("input[name=config_footer_link_color]").val(),
          config_footer_link_hover_color : $("input[name=config_footer_link_hover_color]").val(),
          config_hide_contact : ($("input[name=config_hide_contact]").prop('checked')),
          config_show_commands : ($("input[name=config_show_commands]").prop('checked')),
          config_menu_position : $("select[name=config_menu_position]").val(),
          config_menu_min_height : $("input[name=config_menu_min_height]").val(),
          config_menu_has_logo : ($("input[name=config_menu_has_logo]").prop('checked')),
          config_menu_logo_position : $("select[name=config_menu_logo_position]").val()
          //config_custom_css : $("textarea[name=config_custom_css]").val(),
        },
      },
    }).done(function(msg) {
      toastr.success(msg, "Succès");

    }).fail(function(msg) {
      console.error(msg);
      if(msg.responseText)
        $("#error_msg_cloneTheme").text(msg.responseText).show();
    });
  })

$(document).on('click', "#cloneTheme_btn", function() {
  var that = this;

  $.ajax({
    method: "POST",
    url: "configs/ajax",
    data : {
      cloneTheme: {
        theme_parent: $("#theme_parent").val(),
        theme_name : $("input[name=theme_name]").val(),
      },
    },
  }).done(function(msg) {
    $("#SelectTheme").append($('<option>',
    {
      value : $("input[name=theme_name]").val(),
      text : $("input[name=theme_name]").val(),
      /*selected : "selected",*/
    }))
    toastr.success(msg, "Succès");

  }).fail(function(msg) {
    console.error(msg);
    if(msg.responseText)
    $("#error_msg_cloneTheme").text(msg.responseText).show();
  });
})

$(document).on('click', "#SelectTheme_btn", function() {
  $.ajax({
    method: "POST",
    url: "configs/ajax",
    data : {
      selectTheme:  $("#SelectTheme").val(),
    },
  }).done(function(msg) {
    toastr.success(msg, "Succès");
    console.log(msg);

  }).fail(function(msg) {
    console.error(msg);
    if(msg.responseText)
    $("#error_msg_selectTheme").text(msg.responseText).show();
  });
});
$(document).on('click', "#DownloadTheme_btn", function() {
  window.location="{{ route('company.edit.settings.gettheme', $company->id) }}?theme=" + $("#SelectTheme").val();
});
</script>


{!! JsValidator::formRequest('App\Http\Requests\EditCompanySettingsRequest', '#editForm'); !!}
@stop
