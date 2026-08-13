@extends('layouts.back.master')
@section('title', 'Médias')
@section('content')
	
		<div class="container">
			<div class="content">
				<h1>Importez vos fichiers</h1>
				<form action="{{ URL::to('upload') }}" method="post" enctype="multipart/form-data">
					<label>Selectionner une image à héberger:</label>
				    <input type="file" name="file" id="file">
				    <input type="submit" value="Upload" name="submit">
					<input type="hidden" value="{{ csrf_token() }}" name="_token">
				</form>
			</div>
		</div>

@stop
