@extends('layouts.back.master')
@section('title', 'Etablissements')
@section('content')
{!! Breadcrumbs::render('company.add') !!}
	<h4>Ajouter un établissement</h4>
		<hr />
		
		{!! Form::open(array('route' => array('company.add.post'), 'method' => 'post','name' => 'companyForm', 'id' => 'addForm', 'class' => 'form-wizard validate')) !!}
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="steps-progress">
				<div class="progress-indicator"></div>
			</div>
			
			<ul>
				<li class="active">
					<a href="#tab2-1" data-toggle="tab"><span>1</span>Informations générales</a>
				</li>
				<li>
					<a href="#tab2-2" data-toggle="tab"><span>2</span>Localisation</a>
				</li>
				<li>
					<a href="#tab2-3" data-toggle="tab"><span>3</span>Activités associées</a>
				</li>
				<li>
					<a href="#tab2-4" data-toggle="tab"><span>4</span>Utilisateurs associés</a>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane active" id="tab2-1">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('name', "Nom*", ['class' => 'col-sm-3 control-label' ]) }}
								{{ Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Nom', "data-validate" => "required"]) }}
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('mailNews', "Email d'envoi*", ['class' => 'col-sm-3 control-label' ]) }}
								{{ Form::email('mailNews', null, ['class' => 'form-control', 'placeholder'=>"Email d'envoi de newsletter", "data-validate" => "required"]) }}			
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('tel', "Téléphone", ['class' => 'col-sm-3 control-label' ]) }}
								{{ Form::text('tel', null, ['class' => 'form-control', 'placeholder'=>'Téléphone']) }}
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('fax', "Télécopieur", ['class' => 'col-sm-3 control-label' ]) }}
								{{ Form::text('fax', null, ['class' => 'form-control', 'placeholder'=>'Télécopieur']) }}
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('mail', "Email de contact", ['class' => 'col-sm-3 control-label' ]) }}
								{{ Form::email('mail', null, ['class' => 'form-control', 'placeholder'=>'Email de contact']) }}
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('website', "Site Web", ['class' => 'col-sm-3 control-label' ]) }}
								{{ Form::text('website', null, ['class' => 'form-control', 'placeholder'=>'Site Web']) }}
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="tab2-2">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('ville', "Localisation*", ['class' => 'col-sm-3 control-label' ]) }}
								{{ Form::select('ville', array(), null,  ['id' => 'search-engine', 'minChar' => 2, 'placeholder' => 'Ville', 'source' => route('search.location.name', [':data'])]) }}
								
							</div>
						</div>
					</div>

					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
							    {{ Form::label('cp', "Code Postal*", ['class' => "control-label"]) }}
							    {{ Form::text('cp', null, ['id' => 'cp', 'class' => 'form-control controls', 'placeholder' => 'Code postal']) }}
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
							    {{ Form::label('adresse', "Adresse*", ['class' => "control-label"]) }}
							    {{ Form::text('adresse', null, ['id' => 'adresse', 'class' => 'form-control controls', 'placeholder' => 'Adresse']) }}
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="tab-pane" id="tab2-3">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
							    {{ Form::label('activities', "Activités", ['class' => "control-label"]) }}
                                {{ Form::select('activities[]', $activities, null,  ['multiple'=>'multiple', 'class' => 'form-control multiselect']) }}
							</div>
						</div>
					</div>

				</div>
				<div class="tab-pane" id="tab2-4">
					<div class="btn-centered" style="text-align: center; margin-bottom: 15px;">
						<input id="btn-add" type="button" class="btn btn-secondary" value="Ajouter un utilisateur" />
					</div>

					<div class="panel panel-primary panel-user hidden" data-collapsed="0">
						<div class="panel-heading">
							<div class="panel-title">
								Utilisateur
							</div>
							<div class="panel-options">
								<a href="javascript:" class="btn-close" data-rel="close"><i class="entypo-cancel"></i></a>
							</div>
						</div>
						<div class="panel-body">
							<div class="seperator"><label>Profil</label></div>
							<table class='table user'>

								<tr>
									<td>{!! Form::label('user_mail', 'Email*') !!}</td>
									<td class="{!! $errors->has('mail') ? 'has-error' : '' !!}">
										<input placeholder="Nom" class="form-control" name="user_mail[]" type="text" id="user_mail">
									</td>
								</tr>

								<tr>
									<td>{!! Form::label('user_type', 'Type de compte*') !!}</td>
									<td class="{!! $errors->has('type') ? 'has-error' : '' !!}">
										<select class="form-control" name="user_type[]" aria-invalid="false" id="user_type">
											@foreach($types as $ndx => $value)
											<option value="{{ $ndx }}">{{ $value }}</option>
											@endforeach
										</select>
									</td>
								</tr>
							</table>

							<!-- Info relative à la personne -->
							<div class="seperator"><label>Identité</label></div>
							<table class='table user'>
								<tr>
									<td>{!! Form::label('user_name', 'Nom complet') !!}</td>
									<td class="{!! $errors->has('name') ? 'has-error' : '' !!}">
										<input placeholder="Nom complet" class="form-control" name="user_name[]" type="text" id="user_name">
									</td>
								</tr>
								<tr>
									<td>{!! Form::label('user_last_name', 'Nom') !!}</td>
									<td class="{!! $errors->has('last_name') ? 'has-error' : '' !!}">
										<input placeholder="Nom" class="form-control" name="user_last_name[]" type="text" id="user_last_name">
									</td>
								</tr>
								<tr>
									<td>{!! Form::label('user_first_name', 'Prénom') !!}</td>
									<td class="{!! $errors->has('first_name') ? 'has-error' : '' !!}">
										<input placeholder="Prénom" class="form-control" name="user_first_name[]" type="text" id="user_first_name">
									</td>
								</tr>
							</table>

							<!-- Info relative à ses coordonnées -->
							<div class="seperator"><label>Coordonnées</label></div>
							<table class='table user'>
								<tr>
								    <td>{{ Form::label('user_tel', "Téléphone") }}</td>
								    <td class="{!! $errors->has('tel') ? 'has-error' : '' !!}">
								    	<input placeholder="Téléphone" class="form-control" name="user_tel[]" type="text" id="user_tel">
							        </td>
							    </tr>
							</table>

							<p>
								{{Form::checkbox('user_news[]', 'true')}} 	 {{ Form::label('news', "Recevoir les newsletters et les offres ?", ['class' => "control-label"]) }}
							</p>
						</div>
					</div>
				</div>			
				<ul class="pager wizard">
					<li class="previous">
						<a href="#"><i class="entypo-left-open"></i> Précédent</a>
					</li>
					<li>{!! Form::submit("Ajouter l'établissement", ['class' => 'btn btn-primary']) !!}</li>
					
					<li class="next">
						<a href="#">Suivant <i class="entypo-right-open"></i></a>
					</li>
				</ul>
			</div>
		
			{{ Form::hidden('users', 0) }}

		{!! Form::close() !!}
		@stop
		
		@section('js')
			{{ Html::style('css/jquery-ui/jquery-ui.css') }}	
			{{ Html::style('css/back/ui.multiselect.css') }}	
			{{ Html::script('js/jquery-ui/ui.js') }}  
			{{ Html::style("css/selectize.css")}}
			{{ Html::script("js/selectize.js")}}
    		{{ Html::script("js/search-engine.js")}}

		    {{ Html::script('js/jquery/bootstrap.wizard.min.js') }}  
			{{ Html::script('js/multiselect/ui.js') }} 
			{{ Html::script('js/multiselect/plugins/localisation/jquery.localisation.js') }}   
			{{ Html::script('js/multiselect/plugins/scrollTo/jquery.scrollTo-min.js') }}  
	<!-- Laravel Javascript Validation -->

    {!! JsValidator::formRequest('App\Http\Requests\AddCompanyPostRequest', '#addForm'); !!}

		<script>
	      $(document).ready(function () {

	      	$.localise('ui-multiselect', {language: 'fr', path: '/js/multiselect/locale/'});
			$(".multiselect").multiselect();

			$('#search-engine').searchEngine();

			$('#btn-add').click(function() {
				$('.panel-user').first().clone().removeClass('hidden').appendTo('#tab2-4');
			});

			$('form').submit(function() {
				$('.panel-user').first().remove();
			});
	      });
	    </script>
@stop

