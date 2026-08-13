@extends('layouts.back.master')
@section('title', "Activités")
@section('content')
{!! Breadcrumbs::render('activity.edit', $activity) !!}
	<h4>Editer une activité : {{ $activity->name." (".$activity->category->name." / ".$activity->category->type().")"}} </h4>
		
		<div class="row">
			<div class="col-md-12">
				
				<div class="panel panel-primary" data-collapsed="0">
				

				<div class="panel-body">

					 {!! Form::open(array('route' => array('activity.edit.post', $activity->id), 'method' => 'post', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered')) !!}
						<div class="form-group">
							{{ Form::label('category_id', "Catégorie", ['class' => "control-label col-sm-3"]) }}
								<div class="col-sm-5">
					 				{{ Form::select('category_id', $categories, $activity->category_id,  [ 'class' => 'form-control']) }}
								</div>
						</div>
						<div class="form-group">
							{{ Form::label('slug', "Slug", ['class' => "control-label col-sm-3"]) }}
								<div class="col-sm-5">
					 				{{ Form::text('slug',$activity->slug, ['class' => 'form-control']) }}
								</div>
						</div>
	                    <div class="form-group">
	                    	{{ Form::label('name', "Nom", ['class' => "control-label col-sm-3"]) }}
	                    	<div class="col-sm-5">
	                        	{{ Form::text('name', $activity->name, ['class' => 'form-control']) }}
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
    {!! JsValidator::formRequest('App\Http\Requests\EditActivityPostRequest', '#editForm'); !!}
@stop
