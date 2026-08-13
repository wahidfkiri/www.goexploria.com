@extends('layouts.back.master')
@section('content')
@yield('breadcrumb')
<div class='row'>
	<!-- Menu de gauche -->
	<div class='col-md-2 left-menu-container'>
		<table class='action-menu table table-bordered table-striped'>
			@yield('left-menu')

		</table>
	</div>

	<!-- Contenu -->
	<div class='col-md-10 right-content'>
		@yield('right-content')
	</div>
</div>
<script>
$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>
@stop
