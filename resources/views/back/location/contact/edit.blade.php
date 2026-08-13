@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('location.contact.edit', $country, $location, $contact) !!}
@stop
@section('left-menu')
	@include('back.location.menu')
@stop

@section('right-content')
	<h4>Editer un contact pour {{$location->name}} : {{$contact->name }}</h4>
		<div class="row">
			<div class="col-md-12">
						
				<div class="panel-body">

					{{ Form::open(array('route' => array('location.contact.edit.post', $country->code, $location->id, $contact->id), 'method' => 'post', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered')) }}

					{{ Form::label('name', "Nom", ['class' => "control-label"]) }}
					{{ Form::text('name', $contact->name, ['class' => 'form-control', 'placeholder' => 'Nom']) }}

					{{ Form::label('email', "Courriel", ['class' => "control-label"]) }}
					{{ Form::text('email', $contact->email, ['class' => 'form-control', 'placeholder' => 'Courriel']) }}

					{{ Form::label('phone', "Téléphone", ['class' => "control-label"]) }}
					{{ Form::text('phone', $contact->phone, ['class' => 'form-control', 'placeholder' => 'Téléphone']) }}

					{{ Form::label('mobile', "Cellulaire", ['class' => "control-label"]) }}
					{{ Form::text('mobile', $contact->mobile, ['class' => 'form-control', 'placeholder' => 'Cellulaire']) }}

					{{ Form::label('fax', "Fax", ['class' => "control-label"]) }}
					{{ Form::text('fax', $contact->fax, ['class' => 'form-control', 'placeholder' => 'Fax']) }}

					{{ Form::label('address', "Adresse", ['class' => "control-label"]) }}
					{{ Form::text('address', $contact->address, ['class' => 'form-control', 'placeholder' => 'Adresse']) }}

					{{ Form::label('notes', "Notes", ['class' => "control-label"]) }}
					{{ Form::textarea('notes', $contact->notes, ['class' => 'form-control', 'placeholder' => 'Notes']) }}

					{{ Form::label('is_main_contact', "Est le contact principal?", ['class' => "control-label"]) }}
					{{ Form::checkbox('is_main_contact', null, $contact->is_main_contact) }}

	                <br><br>

					{{ Form::submit('Modifier') }}
	                {{ Form::close() }}
				
				</div>
			
			</div>
		</div>

@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\LocationContactRequest', '#editForm') !!}
@stop
