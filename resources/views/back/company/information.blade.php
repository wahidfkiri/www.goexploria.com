@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.edit.infos', $company) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
<h4>{{$company->name}} - Informations</h4>

{!! Form::open(array('route' => array('company.edit.infos.activation', $company->id), 'method' => 'post','name' => 'companyFormActivation', 'id' => 'editFormActivation', 'files' => true)) !!}

	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<table class='table user'>
		<tr>
			<td>
				@if ($company->is_deactivated)
					{{ Form::submit('Activer l\'établissement')}}
				@else
					{{ Form::submit('Désactiver l\'établissement')}}
				@endif
			</td>
			<td>
				@if ($company->is_deactivated)
					Statut : Désactivé
				@else
					Statut : Activé
				@endif
			</td>
			<td>
				@if ($company->is_deactivated)
					@if (!empty($company->deactivated_date))
						Date de la dernière désactivation : {{ $company->deactivated_date }}
					@else
						Date de la dernière désactivation : &ndash;
					@endif
				@else
					@if (!empty($company->deactivated_date))
						Date de la dernière activation : {{ $company->deactivated_date }}
					@else
						Date de la dernière activation : &ndash;
					@endif
				@endif
			</td>
		</tr>
	</table>

{!! Form::close() !!}

{!! Form::open(array('route' => array('company.edit.infos.post', $company->id), 'method' => 'post','name' => 'companyForm', 'id' => 'editForm', 'files' => true)) !!}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<table class='table user'>
		<tr>
			<td>{{ Form::label('name', "Nom*") }}</td>
			<td>{{ Form::text('name', $company->name, ['class' => 'form-control', 'placeholder'=>'Nom', "data-validate" => "required"]) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('slug', "Slug*") }}</td>
			<td>{{ Form::text('slug', $company->slug, ['id' => 'slug',  "data-validate" => "required", 'class' => 'form-control controls', 'placeholder' => 'Slug']) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('mailNews', "Email d'envoi*") }}</td>
			<td>{{ Form::text('mailNews', $company->mail_news, ['class' => 'form-control', 'placeholder'=>"Email d'envoi de newsletter", "data-validate" => "required"]) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('tel', "Téléphone") }}</td>
			<td>{{ Form::text('tel', $company->coordinate->tel, ['class' => 'form-control', 'placeholder'=>'Téléphone']) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('fax', "Télécopieur") }}</td>
			<td>{{ Form::text('fax', $company->coordinate->fax, ['class' => 'form-control', 'placeholder'=>'Télécopieur']) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('mail', "Email de contact") }}</td>
			<td>{{ Form::text('mail', $company->coordinate->mail, ['class' => 'form-control', 'placeholder'=>'Email de contact']) }}</td>
		</tr>
    <tr>
      <td>{{ Form::label('website', "Site Web") }}</td>
      <td>{{ Form::text('website', $company->coordinate->website, ['class' => 'form-control', 'placeholder'=>'Site Web']) }}</td>
    </tr>
		<tr>
			<td>{{ Form::label('facebook', "Facebook") }}</td>
			<td>{{ Form::text('facebook', $company->socialNetworks->facebook, ['class' => 'form-control', 'placeholder'=>'https://facebook.com/']) }}</td>
		</tr>
    <tr>
			<td>{{ Form::label('twitter', "Twitter") }}</td>
			<td>{{ Form::text('twitter', $company->socialNetworks->twitter, ['class' => 'form-control', 'placeholder'=>'https://twitter.com/']) }}</td>
		</tr>
    <tr>
			<td>{{ Form::label('google_plus', "Google+") }}</td>
			<td>{{ Form::text('google_plus', $company->socialNetworks->google_plus, ['class' => 'form-control', 'placeholder'=>'https://plus.google.com/']) }}</td>
		</tr>
    <tr>
			<td>{{ Form::label('linkedin', "Linkedin") }}</td>
			<td>{{ Form::text('linkedin', $company->socialNetworks->linkedin, ['class' => 'form-control', 'placeholder'=>'https://linkedin.com/']) }}</td>
		</tr>
    <tr>
			<td>{{ Form::label('instagram', "Instagram") }}</td>
			<td>{{ Form::text('instagram', $company->socialNetworks->instagram, ['class' => 'form-control', 'placeholder'=>'https://instagram.com/']) }}</td>
		</tr>
    <tr>
			<td>{{ Form::label('youtube', "Youtube") }}</td>
			<td>{{ Form::text('youtube', $company->socialNetworks->youtube, ['class' => 'form-control', 'placeholder'=>'https://youtube.com/']) }}</td>
		</tr>
    <tr>
			<td>{{ Form::label('pinterest', "Pinterest") }}</td>
			<td>{{ Form::text('pinterest', $company->socialNetworks->pinterest, ['class' => 'form-control', 'placeholder'=>'https://pinterest.com/']) }}</td>
		</tr>
    <tr>
			<td>{{ Form::label('reddit', "Reddit") }}</td>
			<td>{{ Form::text('reddit', $company->socialNetworks->reddit, ['class' => 'form-control', 'placeholder'=>'https://reddit.com/']) }}</td>
		</tr>
	</table>
	<h4>Pictogrammes</h4>
	<table class='table user pictos-list'>
		@if (!empty($pictos))
			@foreach ($pictos as $keyPicto => $picto)
				<tr class="pictos-template pictos-template{{ $keyPicto }}">
					<td><label for="pictos[{{ $keyPicto }}]">Pictogramme</label></td>
					<td><input class="form-control" placeholder="Nom" name="pictos[{{ $keyPicto }}][name]" type="text" value="{{ $picto['name'] }}"></td>
					<td><input class="form-control" placeholder="https://url.com/" name="pictos[{{ $keyPicto }}][url]" type="text" value="{{ $picto['url'] }}"></td>
					<td>
						<input class="form-control" name="pictos[{{ $keyPicto }}][image]" type="file"><br>
						<input class="form-control" name="pictos[{{ $keyPicto }}][oldimage]" type="hidden" value="{{ $picto['image'] }}"><br>
						<img src="{{ url('/') }}/uploads/pictos/{{ $picto['image'] }}" style="width: auto; max-height: 100px;">
					</td>
					<td><button class="form-control remove-pictos">X</button></td>
				</tr>
			@endforeach
		@endif
		<!-- custom.js -->

		@if (!empty($pictos))
			<button class="add-pictos" data-qty="{{ count_of($pictos) }}" style="margin-bottom: 8px;">Ajouter un pictogramme</button>
		@else
			<button class="add-pictos" data-qty="0" style="margin-bottom: 8px;">Ajouter un pictogramme</button>
		@endif
	</table>
	<h4>Options</h4>
	<table class='table user'>
    <tr>
      <td>{{ Form::label('rs_position', "Positions réseaux sociaux") }}</td>
      <td>{{ Form::select('rs_position', array('0' => 'Une ligne', '1' => 'Sous-menu'), $company->rs_position, ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
      <td>{{ Form::label('gallery_home', "Galerie sur l'accueil") }}</td>
      <td>{{ Form::select('gallery_home', array('0' => 'Oui', '1' => 'Non'), $company->gallery_home, ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
      <td>{{ Form::label('newsletter', "Infolettre") }}</td>
      <td>{{ Form::select('newsletter', array('0' => 'Oui', '1' => 'Non'), $company->newsletter, ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
      <td>{{ Form::label('slideshow_height', "Hauteur du slideshow") }}</td>
      <td>{{ Form::select('slideshow_height', array('380' => '370px', '480' => '470px', '580' => '570px'), $company->slideshow_height, ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
      <td>{{ Form::label('footer_text_color', "Couleur du texte footer") }}</td>
      <td>{{ Form::select('footer_text_color', array('#000' => 'Noir', '#fff' => 'Blanc'), $company->footer_text_color, ['class' => 'form-control']) }}</td>
    </tr>
		<tr>
			<td>{{ Form::label( 'default_language', 'Langue par défaut') }}</td>
			<td>{{ Form::select('default_language', $languages, $company->default_language, ['class' => 'form-control']) }}</td>
		</tr>
	</table>
	<h4>Style du menu</h4>
	<table class='table user'>
    <tr>
      <td>{{ Form::label('menu_bg', "Couleur de fond du menu") }}</td>
      <td>{{ Form::text('menu_bg', $company->menu_bg, ['class' => 'form-control', 'placeholder'=>'#FFFFFF']) }}</td>
    </tr>
    <tr>
      <td>{{ Form::label('menu_color', "Couleur des liens du menu") }}</td>
      <td>{{ Form::text('menu_color', $company->menu_color, ['class' => 'form-control', 'placeholder'=>'#000000']) }}</td>
    </tr>
	</table>
	<h4>Contenu de la page d'accueil</h4>
	<table class='table user'>
		<tr>
			<td>{{ Form::label('home_content', "Contenu", ['class' => "control-label"]) }}</td>
			<td>{!! Form::textarea('home_content', $company->home_content, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) !!}</td>
		</tr>
		<tr>
			<td>{{ Form::label('logo_gallery_checkbox', "Afficher le carousel des logos?", ['class' => "control-label"]) }}</td>
			<td>

				{{ Form::checkbox('logo_gallery_checkbox', null, $company->logo_gallery_checkbox) }}
			</td>
		</tr>
	</table>
	<h4>Lien de l'image de la liste</h4>
	<table class='table user'>
		<tr>
			<td>{{ Form::label( 'list_image_title', 'Titre du bouton') }}</td>
			<td>{{ Form::text( 'list_image_title', (!empty($company->list_image_title))?$company->list_image_title:'', ['class' => 'form-control', 'placeholder'=>'']) }}</td>
		</tr>
		<tr>
			<td>{{ Form::label( 'list_image_link', 'Lien du bouton') }}</td>
			<td>{{ Form::text( 'list_image_link', (!empty($company->list_image_link))?$company->list_image_link:'', ['class' => 'form-control', 'placeholder'=>'']) }}</td>
		</tr>
	</table>

	{{ Form::submit('Modifier')}}
{!! Form::close() !!}
<br><br>
<h4>Image de la liste</h4>
<table class='table user'>
    <tr>
        <td>
			<div class="col-md-6">
			<!-- Logo -->
				<div id="preview_list_image"><img alt="Aucune image" title="Image de la liste" width="200" style="width: 200px;" src="{{ URL::asset('uploads/list_images/' . $company->id . '/' . $company_list_image) }}"></div>

				{{ Form::open(array('route' => array('company.edit.list_image.post'), 'method' => 'POST', 'files'=>true, 'id' => 'uploadForm_list_image', 'autocomplete' => 'off', 'class' => 'form-horizontal form-groups-bordered')) }}
				{{ Form::hidden('company_id', $company->id) }}

				<div class="secure"><label>Sélectionnez l'image de la liste</label></div>
				<div class="control-group">
					<div class="controls">
						{{ Form::file('list_image') }}
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

				<input type="button" name="upload" id="upload_list_image" value="Envoyer">
				@if ($company_list_image != '')
					{!! Formatter::deleteButton('list_image'.'-'.$company->id) !!}
					{!! Formatter::delete(route('company.delete.list_image',['company_id' => $company->id]), 'list_image'.'-'.$company->id, "Suppression de l'image de la liste", "Voulez-vous vraiment supprimer l'image de la liste ?" ) !!}
				@endif
				<div class="progress none" style="display: none; margin-top: 10px;">
					<img src="{!! asset('images/uploading.gif') !!}" style="width:auto;">
				</div>
				</form>
			</div><!-- col-md-6 -->
		</td>
	</tr>
</table>
@stop


@section('js')

	{!! JsValidator::formRequest('App\Http\Requests\EditCompanyInfosRequest', '#editForm'); !!}

	<script src="{!! asset('js/back/jquery.form.js') !!}"></script>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			$(".delete").click(function(){
				var value = $(this).attr('data');
				$('#modal-delete-'+value).modal('show');

				return false;
			});

			// List Image upload
			$('body').on('click', '#upload_list_image', function(){
				$('#uploadForm_list_image').ajaxForm({
					target:'#preview_list_image',
					beforeSubmit:function(e){
						$('#uploadForm_list_image .progress').show();
					},
					success:function(e){
						$('#uploadForm_list_image .progress').hide();
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
