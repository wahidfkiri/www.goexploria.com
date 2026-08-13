@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.contact.add', $company) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
<h4>Ajouter un contact pour : {{$company->name}}</h4>
		<div class="row">
			<div class="col-md-12">
						
				<div class="panel-body">

					{{ Form::open(array('route' => array('company.contact.add.post', $company->id), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) }}

						{{ Form::label('name', "Nom", ['class' => "control-label"]) }}
						{{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nom']) }}

						{{ Form::label('email', "Courriel", ['class' => "control-label"]) }}
						{{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Courriel']) }}

						{{ Form::label('phone', "Téléphone", ['class' => "control-label"]) }}
						{{ Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Téléphone']) }}

						{{ Form::label('mobile', "Cellulaire", ['class' => "control-label"]) }}
						{{ Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => 'Cellulaire']) }}

						{{ Form::label('fax', "Fax", ['class' => "control-label"]) }}
						{{ Form::text('fax', null, ['class' => 'form-control', 'placeholder' => 'Fax']) }}

						{{ Form::label('address', "Adresse", ['class' => "control-label"]) }}
						{{ Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Adresse']) }}

						{{ Form::label('notes', "Notes", ['class' => "control-label"]) }}
						{{ Form::textarea('notes', null, ['class' => 'form-control', 'placeholder' => 'Notes']) }}

						{{ Form::label('is_main_contact', "Est le contact principal?", ['class' => "control-label"]) }}
						{{ Form::checkbox('is_main_contact', null) }}

						<br><br>

						{{ Form::submit('Ajouter') }}
	                {{ Form::close() }}
				
				</div>
			
			</div>
		</div>

@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\CompanyContactRequest', '#addForm') !!}
@stop
