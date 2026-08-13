@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.contact', $company) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
<h4>{{$company->name}} : Contacts </h4>
	{!! Formatter::addButton(route('company.contact.add', $company->id))!!}

		</br></br>

		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Courriel</th>
					<th>Téléphone</th>
					<th>Cellulaire</th>
					<th>Fax</th>
					<th>Adresse</th>
					<th>Notes</th>
					<th>Principal?</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			@if (isset($company->contacts))
				@foreach($company->contacts as $contact)
					<tr>
						<td class="search-name">{!! $contact->name !!}</td>
						<td class="search-email">{!! $contact->email !!}</td>
						<td class="search-phone">{!! $contact->phone !!}</td>
						<td class="search-mobile">{!! $contact->mobile !!}</td>
						<td class="search-fax">{!! $contact->fax !!}</td>
						<td class="search-address">{!! $contact->address !!}</td>
						<td class="search-notes">{!! nl2br($contact->notes) !!}</td>
						<td class="search-is_main_contact">{!! $contact->is_main_contact !!}</td>
						<td>

							{!! Formatter::editButton(route('company.contact.edit', [$company->id, $contact->id]))!!}

							{!! Formatter::deleteButton($contact->id)!!}

							{!! Formatter::delete(route('company.contact.delete', [$company->id, $contact->id]), $contact->id, "Supprimer un contact", "Voulez-vous vraiment supprimer le contact ?" ) !!}

						</td>
					</tr>
				@endforeach
			@endif
			</tbody>
		</table>
		
		
		<br />
		<br />

@stop
@section('js')


		
		<script type='text/javascript'>
			$(document).ready(function() {
				   
			    
		/**************************************************************/
	    /************************* SUPPRESSION ************************/
	    /**************************************************************/

	 	   $(".delete").click(function(){
	    	    var value = $(this).attr('data');
			    $('#modal-delete-'+value).modal('show');
	    		return false;
	    	});


           });   
			</script>
@stop
