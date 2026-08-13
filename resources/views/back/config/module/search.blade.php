@extends('layouts.back.master')
@section('title', 'Modules - Permissions')
@section('content')
{!! Breadcrumbs::render('module') !!}
<h3>Gestion des modules</h3>

{!! Formatter::addButton(route('module.add'))!!}

		</br></br>


@stop
@section('js')
<script module='text/javascript'>
	$(document).ready(function() {
	    $(".delete").click(function(){
	        var value = $(this).attr('data');
		    $('#modal-delete-'+value).modal('show');
	    	return false;
	    });

    });   
</script>
@stop
