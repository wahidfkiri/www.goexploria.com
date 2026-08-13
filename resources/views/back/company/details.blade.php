@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.edit', $company) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
<h4>{{$company->name}}</h4>
<p>
	{!! Formatter::seeButton(route('front.company.id', [$company->id]))!!}

	{!! Formatter::button(route('company.page.search', [$company->id]), 'primary', 'fa-file-text fa', 'Pages')!!}

	{!! Formatter::deleteButton($company->id)!!}

	{!! Formatter::delete(route('company.delete', $company->id), $company->id, "Supprimer une entreprise", "Voulez-vous vraiment supprimer l'entreprise " .$company->name ." ?" ) !!}
</p>
<div class='row'>
	<!-- Informations -->
	<div class='col-md-6'>
        <!-- info relative à ses coordonnées -->
        <div class="seperator"><label>Coordonnées</label></div>
        <table class='table user'>
	         <tr>
		        <th>Ville</th>
                <td>{{ $company->coordinate->location->name }}</td>
            </tr>

	        <tr>
	            <th>Code postal</th>
	            <td>{{ $company->coordinate->code_postal }}</td>
            </tr>
	        <tr>
	            <th>Adresse</th>
	            <td>{{ $company->coordinate->adresse }}</td>
            </tr>
        </table>

        <!-- Informations de contact -->
        <div class="seperator"><label>Contact</label></div>
        <table class='table user'>
            <tr>
	            <th>Email d'envoi</th>
	            <td>{{ $company->mail_news }}</td>
            </tr>

			@if (isset($company->coordinate->tel))
	        <tr>
	            <th>Téléphone</th>
	            <td>{{ $company->coordinate->tel }}</td>
            </tr>
    		@endif

			@if (isset($company->coordinate->fax))
	        <tr>
	            <th>Télécopieur</th>
	            <td>{{ $company->coordinate->fax }}</td>
            </tr>
    		@endif

			@if (isset($company->coordinate->mail))
            <tr>
	            <th>Email de contact</th>
	            <td>{{ $company->coordinate->mail }}</td>
            </tr>
    		@endif

			@if (isset($company->coordinate->website))
	        <tr>
	            <th>Site web</th>
	            <td>{{ link_to($company->coordinate->website, $company->coordinate->website) }}</td>
            </tr>
   			@endif



            @if (isset($company->visits))
                <tr>
                    <th>Visites</th>
                    <td>{{ $company->visits }}</td>
                </tr>
            @else
                <tr>
                    <th>Visites</th>
                    <td>0</td>
                </tr>
            @endif


        </table>
    </div>
    <div class='col-md-6'>
		<iframe class="map" src="https://maps.google.com/maps?q={{$company->coordinate->adresse . ' ' . $company->coordinate->code_postal}}&amp;num=1&amp;ie=UTF8&amp;t=m&amp;output=embed"></iframe>

    <div id="logo" class="row">

      <div class="col-md-6">
        <!-- Logo -->
        <div id="preview_logo"><img alt="Aucun logo" title="Logo de l'entreprise" src="{{ URL::asset('uploads/companies/' . $company->id . '/' . $company_logo) }}"></div>

        {{ Form::open(array('route' => array('company.edit.logo.post'), 'method' => 'POST', 'files'=>true, 'id' => 'uploadForm_logo', 'autocomplete' => 'off', 'class' => 'form-horizontal form-groups-bordered')) }}
          {{ Form::hidden('company_id', $company->id) }}

          <div class="secure"><label>Sélectionnez le logo</label></div>
          <div class="control-group">
            <div class="controls">
              {{ Form::file('logo') }}
            	<p class="errors">{!! $errors->first('images') !!}</p>
            	@if(Session::has('error'))
            	<p class="errors">{!! Session::get('error') !!}</p>
            	@endif

              {{ Form::checkbox( 'must_resize', 'true', true ) }} {{ Form::label( 'must_resize', 'Redimensionner' ) }} <br>
              {{ Form::label( 'width', 'Largeur') }} {{ Form::number( 'width', 0 ) }} <br>
              {{ Form::label( 'height', 'Hauteur') }} {{ Form::number( 'height', 100 ) }} <br>
              <br>
            </div>
          </div>

          <input type="button" name="upload" id="upload_logo" value="Envoyer">
          @if ($company_logo != '')
            {!! Formatter::deleteButton('logo'.'-'.$company->id) !!}
            {!! Formatter::delete(route('company.delete.logo',['company_id' => $company->id]), 'logo'.'-'.$company->id, "Suppression du logo", "Voulez-vous vraiment supprimer le logo ?" ) !!}
          @endif
          <div class="progress none" style="display: none; margin-top: 10px;">
              <img src="{!! asset('images/uploading.gif') !!}" style="width:auto;">
          </div>
        </form>
      </div><!-- col-md-6 -->

      <div class="col-md-6"><!-- Image Centrer header -->
        <div id="preview_headImage"><img alt="Aucune image" title="Image d'entete" src="{{ URL::asset('uploads/companies/' . $company->id . '/' . $company_headImage) }}"></div>

        {{ Form::open(array('route' => array('company.edit.logo.post'), 'method' => 'POST', 'files'=>true, 'id' => 'uploadForm_headImage', 'autocomplete' => 'off', 'class' => 'form-horizontal form-groups-bordered')) }}
          {{ Form::hidden('company_id', $company->id) }}
          {{ Form::hidden('is_headImage', true) }}

          <div class="secure"><label>Sélectionnez l'image d'en-tête</label></div>
          <div class="control-group">
            <div class="controls">
              {{ Form::file('logo') }}
              <p class="errors">{!! $errors->first('images') !!}</p>
              @if(Session::has('error'))
              <p class="errors">{!! Session::get('error') !!}</p>
              @endif

              {{ Form::checkbox( 'must_resize', 'true', true ) }} {{ Form::label( 'must_resize', 'Redimensionner' ) }} <br>
              {{ Form::label( 'width', 'Largeur') }} {{ Form::number( 'width', 0 ) }} <br>
              {{ Form::label( 'height', 'Hauteur') }} {{ Form::number( 'height', 100 ) }} <br>
              <br>
            </div>
          </div>

          <input type="button" name="upload" id="upload_headImage" value="Envoyer">
          @if ($company_headImage != '')
            {!! Formatter::deleteButton('headImage'.'-'.$company->id) !!}
            {!! Formatter::delete(route('company.delete.logo',['company_id' => $company->id, 'is_headImage'=> true]), 'headImage'.'-'.$company->id, "Suppression de l'image d'entête", "Voulez-vous vraiment supprimer l'image d'entête ?" ) !!}
          @endif
          <div class="progress none" style="display: none; margin-top: 10px;">
              <img src="{!! asset('images/uploading.gif') !!}" style="width:auto;">
          </div>
        </form>
      </div> <!-- co-md-6 2e column -->
    </div>
    <div class="row" id="logo">
      <div class="col-md-6"><!-- Image Centrer header -->
        <div id="preview_footerImage"><img alt="Aucune image" title="Image du footer" src="{{ URL::asset('uploads/companies/' . $company->id . '/' . $company_footerImage) }}"></div>

        {{ Form::open(array('route' => array('company.edit.logo.post'), 'method' => 'POST', 'files'=>true, 'id' => 'uploadForm_footerImage', 'autocomplete' => 'off', 'class' => 'form-horizontal form-groups-bordered')) }}
          {{ Form::hidden('company_id', $company->id) }}
          {{ Form::hidden('is_footerImage', true) }}

          <div class="secure"><label>Sélectionnez l'image du pied de page</label></div>
          <div class="control-group">
            <div class="controls">
              {{ Form::file('logo') }}
              <p class="errors">{!! $errors->first('images') !!}</p>
              @if(Session::has('error'))
              <p class="errors">{!! Session::get('error') !!}</p>
              @endif

              {{ Form::checkbox( 'must_resize', 'true', true ) }} {{ Form::label( 'must_resize', 'Redimensionner' ) }} <br>
              {{ Form::label( 'width', 'Largeur') }} {{ Form::number( 'width', 0 ) }} <br>
              {{ Form::label( 'height', 'Hauteur') }} {{ Form::number( 'height', 100 ) }} <br>
              <br>
            </div>
          </div>

          <input type="button" name="upload" id="upload_footerImage" value="Envoyer">
          @if ($company_footerImage != '')
            {!! Formatter::deleteButton('footerImage'.'-'.$company->id) !!}
            {!! Formatter::delete(route('company.delete.logo',['company_id' => $company->id, 'is_footerImage'=> true]), 'footerImage'.'-'.$company->id, "Suppression de l'image de pied de page", "Voulez-vous vraiment supprimer l'image de pied de page ?" ) !!}
          @endif
          <div class="progress none" style="display: none; margin-top: 10px;">
              <img src="{!! asset('images/uploading.gif') !!}" style="width:auto;">
          </div>
        </form>
      </div> <!-- co-md-6 2e column -->

      



    </div>

	</div>
</div>


<!-- Activités -->
@if (count_of($activities) > 0)
<div class='row'>
<div class="seperator"><label>Activités</label></div>

	<!-- Tourisme -->
	@if ($activities->where('type_id', 1)->count() > 0)
	<div class='col-md-6'>
		<div class="seperator"><label>Tourisme</label></div>
		<table class='table table-striped'>
			@foreach($activities->where('type_id', 1)->sortBy('category_name')->all() as $activity)
                <tr>
                    <td>{{$activity->name}}</td>
                    <td>{{$activity->category_name}}</td>
                </tr>
            @endforeach
		</table>
	</div>
	@endif

	<!-- Affaire -->
	@if ($activities->where('type_id', 2)->count() > 0)
	<div class='col-md-6'>
		<div class="seperator"><label>Affaire</label></div>
		<table class='table table-striped'>
			@foreach($activities->where('type_id', 2)->sortBy('category_name')->all() as $activity)
                <tr>
                    <td>{{$activity->name}}</td>
                    <td>{{$activity->category_name}}</td>
                </tr>
            @endforeach
		</table>
	</div>
	@endif
</div>
@endif

<!-- Pages -->
@if (count_of($company->pages) > 0)
<div class="seperator"><label>Pages</label></div>

<table class='table table-striped'>
	<tr>
		<th>Nom</th>
		<th>Statut</th>
	</tr>
	@foreach($company->pages()->orderBy('rank', 'desc')->orderBy('name')->get() as $page)
        <tr>
            <td>{{$page->name}}</td>
            <td>{{$page->statut()}}</td>
        </tr>
    @endforeach
</table>

@endif

@stop

@section('js')
<script src="{!! asset('js/back/jquery.form.js') !!}"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    $(".delete").click(function(){
        var value = $(this).attr('data');
        $('#modal-delete-'+value).modal('show');

        return false;
    });

    // Logo upload
    $('body').on('click', '#upload_logo', function(){
        $('#uploadForm_logo').ajaxForm({
          target:'#preview_logo',
          beforeSubmit:function(e){
              $('#uploadForm_logo .progress').show();
          },
          success:function(e){
              $('#uploadForm_logo .progress').hide();
              document.location.reload(true);
          },
          error:function(e){
            var errors = $.parseJSON(e.responseText);
          }
      }).submit();
    });
    $('body').on('click', '#upload_headImage', function(){
        $('#uploadForm_headImage').ajaxForm({
          target:'#preview_headImage',
          beforeSubmit:function(e){
              $('#uploadForm_headImage .progress').show();
          },
          success:function(e){

              $('#uploadForm_headImage .progress').hide();
              document.location.reload(true);
          },
          error:function(e){
            var errors = $.parseJSON(e.responseText);
          }
      }).submit();
    });
    $('body').on('click', '#upload_footerImage', function(){
        $('#uploadForm_footerImage').ajaxForm({
          target:'#preview_footerImage',
          beforeSubmit:function(e){
              $('#uploadForm_footerImage .progress').show();
          },
          success:function(e){

              $('#upload_footerImage .progress').hide();
              document.location.reload(true);
          },
          error:function(e){
            var errors = $.parseJSON(e.responseText);
          }
      }).submit();
    });

});
</script>
@stop
