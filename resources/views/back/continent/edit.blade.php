@extends('layouts.back.master')
@section('title', 'Continent')
@section('content')
{!! Breadcrumbs::render('continent.edit', $continent) !!}
	<h4>Modifier un continent : {{$continent->name}}</h4>
				
		<div class="row">
			<div class="col-md-12">
				
				<div class="panel panel-primary" data-collapsed="0">
				<div class="panel-body">
					 {{ Form::open(array('route' => array('continent.edit.post', $continent->id), 'method' => 'post', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered')) }}
							
	                    <div class="form-group">
	                    {{ Form::label('name', "Nom", ['class' => "control-label col-sm-3"]) }}
	                    	
	                    	<div class="col-sm-5">
	                        	{{ Form::text('name',  $continent->name, ['class' => 'form-control', 'placeholder' => 'Nom']) }}
	                        </div>
	                    </div>

	                    <div class="form-group">
	                    {{ Form::label('code', "Code", ['class' => "control-label col-sm-3"]) }}
	                    	
	                    	<div class="col-sm-5">
	                        	{{ Form::text('code',  $continent->code, ['class' => 'form-control', 'placeholder' => 'Code']) }}
	                        </div>
	                    </div>

	                   	<div class="form-group">
	                    	{{ Form::label('rank', "Rang", ['class' => "control-label col-sm-3"]) }}
	                    	
	                    	<div class="col-sm-5">
	                        	{{ Form::number('rank',  $continent->rank, ['class' => 'form-control', 'placeholder' => 'Rang']) }}
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
    {!! JsValidator::formRequest('App\Http\Requests\EditContinentPostRequest', '#editForm'); !!}

@stop
