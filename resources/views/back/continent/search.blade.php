@extends('layouts.back.master')
@section('title', 'Continent')
@section('content')
{!! Breadcrumbs::render('continent') !!}

<h3>Ajouter</h3>

	{!! Formatter::addButton(route('continent.add'))!!}

<h3>Disponibles</h3>
<!-- Liste des résultats-->
<table class="table table-bordered table-striped datatable">
	<thead>
	<tr>
		<th>Continent</th>
		<th>Rang</th>
		<th>Actions</th>
	</tr>
	</thead><tbody>
	@foreach ($continents as $continent)
	<tr>
		<td>{{ $continent->name }}</td>
		<td>{{ $continent->rank }}</td>
		</td>
		<td>
			{!! Formatter::seeButton(route('front.continent.id', [$continent->id]))!!}

			{!! Formatter::editButton(route('continent.edit', [$continent->id]))!!}


			{!! Formatter::deleteButton($continent->id)!!}

			{!! Formatter::delete(route('continent.delete', $continent->id), $continent->id, "Supprimer un continent", "Voulez-vous vraiment supprimer le continent " .$continent->name ." ?" ) !!}

		</td>
	</tr>
	@endforeach
	</tbody>

</table>


@stop

@section('js')
    <script type='text/javascript'>
      $(document).ready(function () {

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
