@extends('layouts.back.master')
@section('title', 'Continent')
@section('content')
{!! Breadcrumbs::render('continent.add') !!}
	<h4>Ajouter un continent</h4>
				
		<div class="row">
			<div class="col-md-12">
				
				<div class="panel panel-primary" data-collapsed="0">
				<div class="panel-body">
					 {{ Form::open(array('route' => array('continent.add.post'), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) }}
							
	                    <div class="form-group">
	                    {{ Form::label('name', "Nom*", ['class' => "control-label col-sm-3"]) }}
	                    	
	                    	<div class="col-sm-5">
	                        	{{ Form::text('name',  null, ['class' => 'form-control', 'placeholder' => 'Nom']) }}
	                        </div>
	                    </div>

	                    <div class="form-group">
	                    {{ Form::label('code', "Code*", ['class' => "control-label col-sm-3"]) }}
	                    	
	                    	<div class="col-sm-5">
	                        	{{ Form::text('code',  null, ['class' => 'form-control', 'placeholder' => 'Code']) }}
	                        </div>
	                    </div>

	                   	<div class="form-group">
	                    	{{ Form::label('rank', "Rang", ['class' => "control-label col-sm-3"]) }}
	                    	
	                    	<div class="col-sm-5">
	                        	{{ Form::number('rank',  null, ['class' => 'form-control', 'placeholder' => 'Rang']) }}
	                        </div>
	                    </div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-5">
								{{ Form::submit('Ajouter') }}
							</div>
						</div>
	                {{ Form::close() }}
					</div>
				
				</div>
			
			</div>
		</div>

@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\AddContinentPostRequest', '#addForm'); !!}

@stop

