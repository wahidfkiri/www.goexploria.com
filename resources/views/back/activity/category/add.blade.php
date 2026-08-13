@extends('layouts.back.master')
@section('title', "Catégories d'activités")
@section('content')
{!! Breadcrumbs::render('activity.category.add') !!}

	<h4>Ajouter une catégorie d'activité</h4>
	
		
		<div class="row">
			<div class="col-md-12">
				
				<div class="panel panel-primary" data-collapsed="0">
				
				<div class="panel-body">
					 {!! Form::open(array('route' => array('activity.category.add.post'), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) !!}
						<div class="form-group">
							{{ Form::label('type_id', "Type de catégorie", ['class' => "control-label col-sm-3"]) }}
								<div class="col-sm-5">
									{{ Form::select('type_id', $types, null ,['class' => 'form-control']) }}
								</div>
							</div>
	                    <div class="form-group">
	                    	{{ Form::label('name', "Nom", ['class' => "control-label col-sm-3"]) }}
	                    	<div class="col-sm-5">
	                        	{{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nom']) }}
	                        </div>
	                    </div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-5">
								{!! Form::submit('Ajouter') !!}
							</div>
						</div>
	                {!! Form::close() !!}
					</div>
				</div>
			
			</div>
		</div>
		@stop

@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\AddActivityCategoryPostRequest', '#addForm'); !!}
@stop
