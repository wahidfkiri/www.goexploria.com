@extends('layouts.back.master')
@section('title', 'Etablissements')
@section('content')
@if (Session::has('message'))
<p class="alert alert-success">{!! Session::get('message')!!}</p>
@endif
{!! Breadcrumbs::render('company') !!}
<h3>Importation d'établissements</h3>
		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					Paramètres
				</div>
						
			</div>
					
			<div class="panel-body">
				{{ Form::open(array('route' => array('company.import'), 'method' => 'post', 'class' => 'validate', 'id' => 'importForm', 'enctype' => 'multipart/form-data')) }}
				<table class="table">
					<tr>
						<td>{{ Form::label('name', 'Fichier XML') }}</td>
						<td><input name="upload" type="file" accept=".xml" date-validate="required"></td>
					</tr>
					<tr>
						<td>{{ Form::label('name', 'Localisation') }}</td>
						<td>
							<div class="row hidden">
								<div class="form-group col-md-6">
									{{ Form::select('ville', array(), null,  ['id' => 'search-engine', 'minChar' => 2, 'placeholder' => 'Ville', 'source' => route('search.location.name', [':data']), "data-validate" => "required"]) }}
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('name', 'Activités') }}</td>
						<td>
							<div class="row hidden">
								<div class="form-group col-md-6">
	                                {{ Form::select('activities[]', $activities, null,  ['multiple'=>'multiple', 'class' => 'form-control multiselect']) }}
								</div>
							</div>
						</td>
					</tr>
				</table>

				{{ Form::button("<i class='entypo-list-add'></i> Importer", ['class'=>'btn btn-primary btn-sm btn-icon icon-left', 'type' => 'submit']) }}
				{!! Form::close() !!}
			</div>
		</div>

@stop

@section('js')
	{{ Html::style('css/jquery-ui/jquery-ui.css') }}	
	{{ Html::style('css/back/ui.multiselect.css') }}

	<style type="text/css">
		.selectize-control.single {
			margin-left: 0;
		}
	</style>

	{{ Html::script('js/jquery-ui/ui.js') }}  
	{{ Html::style("css/selectize.css")}}
	{{ Html::script("js/selectize.js")}}
	{{ Html::script("js/search-engine.js")}}

    {{ Html::script('js/jquery/bootstrap.wizard.min.js') }}  
	{{ Html::script('js/multiselect/ui.js') }} 
	{{ Html::script('js/multiselect/plugins/localisation/jquery.localisation.js') }}   
	{{ Html::script('js/multiselect/plugins/scrollTo/jquery.scrollTo-min.js') }}

	<!-- Laravel Javascript Validation -->

    {!! JsValidator::formRequest('App\Http\Requests\ImportCompanyPostRequest', '#importForm'); !!}

	<script>
      $(document).ready(function () {

      	$.localise('ui-multiselect', {language: 'fr', path: '/js/multiselect/locale/'});
		$(".multiselect").multiselect();

		$('#search-engine').searchEngine();

		// Simple hack to eliminate flickers
		$('.panel-body .hidden').removeClass('hidden');
      });
    </script>
@stop
