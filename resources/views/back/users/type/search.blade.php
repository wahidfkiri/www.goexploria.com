@extends('layouts.back.master')
@section('title', "Type d'utilisateurs")
@section('content')
{!! Breadcrumbs::render('user.type') !!}
<h3>Types d'utilisateurs</h3>
			{!! Formatter::addButton(route('user.type.add'))!!}

		</br></br>

		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Type</th>
					<th>Libellé</th>
					<th>Identifiant</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			@foreach($types as $type)
			    <tr>
					<td>{{ $type->name }}</td>
					
					<td >{{ $type->libelle }}</td>
					<td >{{ $type->slug }}</td>
					<td>
						{!! Formatter::button(route('user.type.access', [$type->id]), 'warning', 'fa fa-check', 'Permissions')!!}

						{!! Formatter::editButton(route('user.type.edit', [$type->id]))!!}

						{!! Formatter::deleteButton($type->id)!!}

						{!! Formatter::delete(route('user.type.delete', $type->id), $type->id, "Supprimer un type d'utilisateur", "Voulez-vous vraiment supprimer le type " .$type->name ." ?" ) !!}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>	
		
		<br />
		<br />


@stop
@section('js')
<script type='text/javascript'>
	$(document).ready(function() {
	    $(".delete").click(function(){
	        var value = $(this).attr('data');
		    $('#modal-delete-'+value).modal('show');
	    	return false;
	    });

    });   
</script>
@stop
