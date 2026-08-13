@extends('layouts.back.master')
@section('title', 'Type de destinations')
@section('content')
{!! Breadcrumbs::render('location.type.add', $country) !!}
	<h4>Ajouter un type de destinations</h4>
		<div class="row">
			<div class="col-md-12">
				
				<div class="panel panel-primary" data-collapsed="0">
			
				<div class="panel-body">

					 {{ Form::open(array('route' => array('location.type.add.post', $country->code), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) }}
						<div class="form-group">
							{{ Form::label('parentID', "Type de parent", ['class' => "control-label col-sm-3"]) }}
								<div class="col-sm-5">
								{!! Form::select('parentID', $parent, null,  ['disabled' => (count_of($parent) == 0 ? 'disabled' : 'none'), 'class' => 'form-control']) !!}
								</div>
						</div>
	                    <div class="form-group">
	                    	{{ Form::label('name', "Nom du type de destinations*", ['class' => "control-label col-sm-3"]) }}
	                    	<div class="col-sm-5">
	                        	{{ Form::text('name', null, ['class' => 'form-control']) }}
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
    {!! JsValidator::formRequest('App\Http\Requests\AddLocationTypePostRequest', '#addForm'); !!}
@stop
