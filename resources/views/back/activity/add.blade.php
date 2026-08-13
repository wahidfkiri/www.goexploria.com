@extends('layouts.back.master')
@section('title', "Activités")
@section('content')
{!! Breadcrumbs::render('activity.add') !!}
	<h4>Ajouter une activité</h4>
			
		<div class="row">
			<div class="col-md-12">
				
				<div class="panel panel-primary" data-collapsed="0">
				
				<div class="panel-body">
				@if (count_of($categories) > 0)
					 {{ Form::open(array('route' => array('activity.add.post'), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) }}
						<div class="form-group">
						{{ Form::label('category_id', "Catégorie", ['class' => "control-label col-sm-3"]) }}

								<div class="col-sm-5">
									{{ Form::select('category_id', $categories, null ,['class' => 'form-control']) }}
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
								{{ Form::submit('Ajouter') }}
							</div>
						</div>
	                {{ Form::close() }}
					</div>
				@else
					<div class='error'>
						<p class='error-message'>Aucune catégorie d'activités disponible</p>
						<a href="{{ route('activity.category.add') }}" class="btn btn-primary btn-sm btn-icon icon-left">
						<i class="entypo-plus"></i>Ajouter une catégorie</a>
					</div>
				@endif
				
				</div>
			
			</div>
		</div>
		@stop

@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\AddActivityPostRequest', '#addForm'); !!}
@stop
