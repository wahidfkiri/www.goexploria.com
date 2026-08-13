@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.edit.activity', $company) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
<h4>{{$company->name}} - Activités</h4>
{!! Form::open(array('route' => array('company.edit.activity.post', $company->id), 'method' => 'post','name' => 'companyForm', 'id' => 'editForm')) !!}
	<table class='col-md-12'>
		<tr>
			<td>
    		{{ Form::select('activities[]', $activities, $company->activitiesDetails()->pluck('id')->all(),  ['multiple'=>'multiple', 'class' => 'form-control multiselect']) }}
    		</td>
    	</tr>
    </table>
	{{ Form::submit('Modifier')}}
{!! Form::close() !!}
@stop
@section('js')
	{{ Html::style('css/jquery-ui/jquery-ui.css') }}	
	{{ Html::style('css/back/ui.multiselect.css') }}	
	{{ Html::script('js/jquery-ui/ui.js') }}  
	{{ Html::script('js/multiselect/ui.js') }} 
	{{ Html::script('js/multiselect/plugins/localisation/jquery.localisation.js') }}   
	{{ Html::script('js/multiselect/plugins/scrollTo/jquery.scrollTo-min.js') }}  

	<!-- Laravel Javascript Validation -->


<script>
    $(document).ready(function () {

     	$.localise('ui-multiselect', {language: 'fr', path: '/js/multiselect/locale/'});
		$(".multiselect").multiselect();


    });
</script>
@stop
