@extends('layouts.back.master')
@section('title', 'Utilisateurs')
@section('content')
{!! Breadcrumbs::render('user') !!}
<h3>Utilisateurs</h3>
		<p>	{!! Formatter::addButton(route('user.add'))!!}</p>

		<div class="panel panel-primary" data-collapsed="1">
			<div class="panel-heading">

				<div class="panel-title">
					Rechercher
				</div>

				<div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>  </div>
						
			</div>
					
			<div class="panel-body">
				{{ Form::open(array('route' => array('user.search.post'), 'method' => 'post')) }}
				<table class="table">
					<tr>
						<td>{{ Form::label('name', 'Nom complet') }}</td>
						<td>{{ Form::text('name', isset($search->name) ? $search->name : '', ['id' => 'name-search', 'class' => 'form-control', 'placeholder' => 'Nom complet']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('lastName', 'Nom') }}</td>
						<td>{{ Form::text('lastName', isset($search->lastName) ? $search->lastName : '', ['id' => 'last-name-search', 'class' => 'form-control', 'placeholder' => 'Nom']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('firstName', 'Prénom') }}</td>
						<td>{{ Form::text('firstName', isset($search->firstName) ? $search->firstName : '', ['id' => 'first-name-search', 'class' => 'form-control', 'placeholder' => 'Prénom']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('mail', 'Email') }}</td>
						<td>{{ Form::text('mail', isset($search->mail) ? $search->mail : '', ['id' => 'mail-search', 'class' => 'form-control', 'placeholder' => 'Email']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('news', 'Newsletter') }}</td>
						<td>{{ Form::select('news', ['-1' => 'Tous'] + $news, isset($search->news) ? $search->news : -1, ['id' => 'news-search', 'class' => 'form-control']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('type', 'Type') }}</td>
						<td>{{ Form::select('type', ['-1' => 'Tous'] + $types, isset($search->type) ? $search->type : -1, ['id' => 'type-search', 'class' => 'form-control']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('rang', 'Rang') }}</td>
						<td>{{ Form::select('rang', ['-1' => 'Tous'] + $rangs, isset($search->rang) ? $search->rang : -1, ['id' => 'rang-search', 'class' => 'form-control']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('statut', 'Statut') }}</td>
                                                <td>{{ Form::select('statut', ['-1' => 'Tous'] + $statuts, isset($search->statut) ? $search->statut : null, ['id' => 'statut-search', 'class' => 'form-control']) }}</td>
                                        </tr>
				</table>
				{{ Form::button("<i class='entypo-search'></i> Rechercher", ['class'=>'btn btn-success btn-sm btn-icon icon-left', 'type' => 'submit']) }}
				<a href="{{ route('user.search.clear') }}">{{ Form::button("<i class='entypo-cancel'></i> Effacer", ['id'=> 'clear', 'class'=>'btn btn-primary btn-sm btn-icon icon-left']) }}</a>
				{{ Form::close() }}
			</div>
		</div>
		
		<table class="table table-bordered table-striped" id="table">
			<thead>
				<tr>
					<th>Nom complet</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Email</th>
					<th>Type</th>
					<th>Rang</th>
					<th>Statut</th>
					<th>Newsletter</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			@foreach($users as $user)
			    <tr>
			    	<td class="search-name">{{ $user->name }}</td>
			        <td class="search-last-name">{{ $user->last_name }}</td>
			        <td class="search-fist-name">{{ $user->first_name }}</td>
			        <td class="search-mail">{{ $user->email }}</td>
			        <td data='{{$user->type->id}}'  class="search-type">
			        	{{ $user->type->name }}
			        </td>
			        <td data='{{$user->is_admin}}'  class="search-rang">
			        	{{ $user->rang()->name }}
			        </td>
			        <td data='{{$user->is_activated}}' class="search-statut">
			        	{{$user->statut()->name}}   
			        </td>
			        <td data='{{$user->is_news_enabled}}' class="search-news">
			        	{{ $user->news() }}
			        </td>
			        <td>	
			        	{!! Formatter::button(route('user.details', [$user->id]), 'info', 'fa fa-eye', "Détails")!!}

			        	{!! Formatter::deleteButton($user->id)!!}

			        	{!! Formatter::delete(route('user.delete', $user->id), $user->id, "Supprimer un utilisateur", "Etes-vous sûr de vouloir supprimer le compte de ".$user->email ." ?" ) !!}
					</td>
			        
			        
			    </tr>
			@endforeach
			</tbody>
		</table>
		{{ $users->render() }}
		
		
		<br />
		<br />
@stop

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		        
	    /**************************************************************/
	    /************************* SUPPRESSION ************************/
	    /**************************************************************/
	    $(".delete").click(function(){
	        var value = $(this).attr('data');
		    $('#modal-delete-'+value).modal('show');
					
	    	return false;
	    });
		        
	    /**************************************************************/
	    /************************* RECHERCHE **************************/
	    /**************************************************************/
        /* Clique sur le nom */
	    $(".search-last-name").click(function(){
		    var value = $(this).html();
		    $('#last-name-search').val(value);
	    });
				
	    /** Clique sur le nom complet */
	    $(".search-name").click(function(){
		    var value = $(this).html();
    	    $('#name-search').val(value);
	    });

	    /** Clique sur le prénom */
	    $(".search-first-name").click(function(){
		    var value = $(this).html();
    	    $('#first-name-search').val(value);
	    });
				
	    /** Clique sur le mail*/
	    $(".search-mail").click(function(){
		    var value = $(this).html();
		    $('#mail-search').val(value);
	    });

	    /** Clique sur le type*/
	    $(".search-type").click(function(){
		    var value = $(this).attr('data');
		    $('#type-search').val(value);
	    });

	    /** Clique sur le rang*/
	    $(".search-rang").click(function(){
		    var value = $(this).attr('data');
		    $('#rang-search').val(value);
	    });

	    /** Clique sur le statut de newsletter */
	    $(".search-news").click(function(){
		    var value = $(this).attr('data');
		    $('#news-search').val(value);
	    });

		/** Clique sur le statut */
	    $(".search-statut").click(function(){
		    var value = $(this).attr('data');
		    $('#statut-search').val(value);
	    });
	}); 
</script>
@stop
