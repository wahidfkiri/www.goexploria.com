@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.comment', $company) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
<h4>{{$company->name}} : Commentaires </h4>
	{!! Formatter::addButton(route('company.comment.add', $company->id))!!}

		</br></br>

		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Contenu</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			@foreach($company->comments as $comment)
			    <tr>
					<td class="search-name">{!! $comment->content !!}</td>
					<td>

						{!! Formatter::editButton(route('company.comment.edit', [$company->id, $comment->id]))!!}

						{!! Formatter::deleteButton($comment->id)!!}

						{!! Formatter::delete(route('company.comment.delete', [$company->id, $comment->id]), $comment->id, "Supprimer un commentaire", "Voulez-vous vraiment supprimer le commentaire ?" ) !!}

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
