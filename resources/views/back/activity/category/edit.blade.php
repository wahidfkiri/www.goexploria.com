@extends('layouts.back.master')
@section('title', "Catégories d'activités")
@section('content')
{!! Breadcrumbs::render('activity.category.edit', $category) !!}

	<h4>Modifier une catégorie d'activités : {{ $category->name." (".$category->type().")"}}</h4>
		<br />
		
		
		<div class="row">
			<div class="col-md-12">
				
				<div class="panel panel-primary" data-collapsed="0">
				<div class="panel-body">

					 {!! Form::open(array('route' => array('activity.category.edit.post', $category->id), 'method' => 'post', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered')) !!}
						<div class="form-group">
							{{ Form::label('type_id', "Type", ['class' => "control-label col-sm-3"]) }}
								<div class="col-sm-5">
					 				{{ Form::select('type_id', $types, $category->type_id, ['class' => 'form-control']) }}
								</div>
						</div>
						<div class="form-group">
							{{ Form::label('slug', "Slug", ['class' => "control-label col-sm-3"]) }}
								<div class="col-sm-5">
					 				{{ Form::text('slug',$category->slug, ['class' => 'form-control']) }}
								</div>
						</div>
	                    <div class="form-group">
	                    	<label for="field-1" class="col-sm-3 control-label">Nom</label>
	                    	<div class="col-sm-5">
	                        	{{ Form::text('name', $category->name, ['class' => 'form-control']) }}
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
    {!! JsValidator::formRequest('App\Http\Requests\EditActivityCategoryPostRequest', '#editForm'); !!}
@stop
