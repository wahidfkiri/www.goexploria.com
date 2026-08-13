@extends('layouts.back.master')
@section('title', 'Type de destinations')
@section('content')
{!! Breadcrumbs::render('location.type.edit', $country, $type) !!}
	<h4>Modifier un type de destinations : {{$type->name}}</h4>
				
		<div class="row">
			<div class="col-md-12">
				
				<div class="panel panel-primary" data-collapsed="0">
				<div class="panel-body">
					 {{ Form::open(array('route' => array('location.type.edit.post', $country->code, $type->id), 'method' => 'post', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered')) }}
							
						<div class="form-group">
							{{ Form::label('parentID', "Parent", ['class' => "control-label col-sm-3"]) }}
								<div class="col-sm-5">
								{!! Form::text('parentID', $type->head != null ? $type->head->name: 'Aucun',  ['class' => 'form-control', 'disabled' => 'disabled']) !!}
								</div>
						</div>
	                    <div class="form-group">
	                    {{ Form::label('name', "Nom*", ['class' => "control-label col-sm-3"]) }}
	                    	
	                    	<div class="col-sm-5">
	                        	{{ Form::text('name',  $type->name, ['class' => 'form-control']) }}
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
    {!! JsValidator::formRequest('App\Http\Requests\EditLocationTypePostRequest', '#editForm'); !!}

@stop
