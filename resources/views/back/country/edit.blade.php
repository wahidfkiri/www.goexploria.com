@extends('layouts.back.master')
@section('title', 'Pays')
@section('content')
{!! Breadcrumbs::render('country.edit', $country) !!}
	<h4>Modifier un pays: {{$country->name . " (".$country->continent->name.")"}}</h4>
				
		<div class="row">
			<div class="col-md-12">
				
				<div class="panel panel-primary" data-collapsed="0">
				<div class="panel-body">
					 {{ Form::open(array('route' => array('country.edit.post', $country->id), 'method' => 'post', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered')) }}
							
						<div class="form-group">
							{{ Form::label('continent', "Continent", ['class' => "control-label col-sm-3"]) }}
								<div class="col-sm-5">
								{!! Form::select('continent', $continents, $country->continent->id,  ['class' => 'form-control']) !!}
								</div>
						</div>
	                    <div class="form-group">
	                    {{ Form::label('name', "Nom", ['class' => "control-label col-sm-3"]) }}
	                    	
	                    	<div class="col-sm-5">
	                        	{{ Form::text('name',  $country->name, ['class' => 'form-control', 'placeholder' => 'Nom']) }}
	                        </div>
	                    </div>

	                    <div class="form-group">
	                    	{{ Form::label('slug', "Slug", ['class' => "control-label col-sm-3"]) }}
	                    	
	                    	<div class="col-sm-5">
	                        	{{ Form::text('slug',  $country->slug, ['class' => 'form-control', 'placeholder' => 'Slug']) }}
	                        </div>
	                    </div>

	                    <div class="form-group">
	                    {{ Form::label('code', "Code", ['class' => "control-label col-sm-3"]) }}
	                    	
	                    	<div class="col-sm-5">
	                        	{{ Form::text('code',  $country->code, ['class' => 'form-control', 'placeholder' => 'Code']) }}
	                        </div>
	                    </div>

	                   	<div class="form-group">
	                    	{{ Form::label('rank', "Rang", ['class' => "control-label col-sm-3"]) }}
	                    	
	                    	<div class="col-sm-5">
	                        	{{ Form::number('rank',  $country->rank, ['class' => 'form-control', 'placeholder' => 'Rang']) }}
	                        </div>
	                    </div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-5">
								{{ Form::submit('Editer') }}
							</div>
						</div>
	                {{ Form::close() }}
					</div>
				
				</div>
			
			</div>
		</div>

@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\EditCountryPostRequest', '#editForm'); !!}

@stop
