@extends('layouts.front.master') @section('title', 'Inscription')
@section('content') {!!
Form::open(['route' => 'account.register.post', 'method' => 'post',
'id'=>'inscription']) !!}
<!-- Info relative au site -->
<div class="seperator"><label>Profil</label></div>
<table class='table user'>


	<tr>
		<td>{!! Form::label('mail', 'Email*') !!}</td>
		<td class="{!! $errors->has('mail') ? 'has-error' : '' !!}">{!!
			Form::text('mail', null, ['class' => 'form-control',
			'placeholder' => 'Email']) !!} {!! $errors->first('mail', '<small
			class="help-block">:message</small>') !!}
		</td>
	</tr>
	
	<tr>
		<td>{!! Form::label('password', 'Mot de passe*') !!}</td>
		<td class="{!! $errors->has('password') ? 'has-error' : '' !!}">{!!
			Form::password('password', ['class' => 'form-control', 'placeholder'
			=> 'Password']) !!} {!! $errors->first('password', '<small
			class="help-block">:message</small>') !!}
		</td>
	</tr>
	<tr>
		<td>{!! Form::label('pass_confirmation', 'Confirmation*') !!}</td>
		<td
			class="{!! $errors->has('password_confirmation') ? 'has-error' : '' !!}">
			{!! Form::password('password_confirmation', ['class' =>
			'form-control', 'placeholder' => 'Password']) !!} {!!
			$errors->first('password_confirmation', '<small class="help-block">:message</small>')
			!!}
		</td>
	</tr>

	<tr>
		<td>{!! Form::label('type', 'Type de compte*') !!}</td>
		<td class="{!! $errors->has('type') ? 'has-error' : '' !!}">
			{!! Form::select('type', $types, null, [ 'class' => 'form-control']) !!} 
			{!! $errors->first('type', '<small class="help-block">:message</small>') !!}
			<p>
			@foreach($typesDetails as $type)
				<div class='hidden type-detail' id="type-{{$type->id}}">{{$type->libelle}}</div>
			@endforeach
			</p>
		</td>
	</tr>
</table>

<!-- Info relative à la personne -->
<div class="seperator"><label>Identité</label></div>
<table class='table user'>
	<tr>
		<td>{!! Form::label('name', 'Nom complet') !!}</td>
		<td class="{!! $errors->has('name') ? 'has-error' : '' !!}">
			{!! Form::text('name', null, ['placeholder' => 'Nom complet', 'class' => 'form-control']) !!} 
			{!! $errors->first('name', '<small class="help-block">:message</small>') !!}
		</td>
	</tr>
	<tr>
		<td>{!! Form::label('last_name', 'Nom*') !!}</td>
		<td class="{!! $errors->has('last_name') ? 'has-error' : '' !!}">
			{!! Form::text('last_name', null, ['placeholder' => 'Nom', 'class' => 'form-control']) !!} 
			{!! $errors->first('last_name', '<small class="help-block">:message</small>') !!}
		</td>
	</tr>
	<tr>
		<td>{!! Form::label('first_name', 'Prénom*') !!}</td>
		<td class="{!! $errors->has('first_name') ? 'has-error' : '' !!}">
			{!! Form::text('first_name', null, ['placeholder' => 'Prénom', 'class' => 'form-control']) !!} 
			{!! $errors->first('first_name', '<small class="help-block">:message</small>') !!}
		</td>
	</tr>
</table>

<!-- Info relative à ses coordonnées -->
<div class="seperator"><label>Coordonnées</label></div>
<table class='table user'>
	 <tr>
		<td>{{ Form::label('ville', "Localisation") }}</td>
        <td class="{!! $errors->has('ville') ? 'has-error' : '' !!}">
            {{ Form::select('ville', [], null,  ['id' => 'search-engine-location', 'minChar' => 2, 'placeholder' => 'Ville', 'source' => route('search.location.name', [':data'])]) }}
            {!! $errors->first('ville', '<small class="help-block">:message</small>') !!}
        </td>
    </tr>

    <tr>
	    <td>{{ Form::label('cp', "Code Postal") }}</td>
	    <td class="{!! $errors->has('cp') ? 'has-error' : '' !!}">
	    	{{ Form::text('cp', null, ['placeholder' => 'Code postal', 'class' => 'form-control']) }}
	    	{!! $errors->first('cp', '<small class="help-block">:message</small>') !!}
        </td>
    </tr>

	<tr>
	    <td>{{ Form::label('adresse', "Adresse") }}</td>
	    <td class="{!! $errors->has('adresse') ? 'has-error' : '' !!}">
	    	{{ Form::text('adresse', null, ['placeholder' => 'Adresse', 'class' => 'form-control']) }}
	    	{!! $errors->first('adresse', '<small class="help-block">:message</small>') !!}
        </td>
    </tr>

	<tr>
	    <td>{{ Form::label('tel', "Téléphone") }}</td>
	    <td class="{!! $errors->has('tel') ? 'has-error' : '' !!}">
	    	{{ Form::text('tel', null, ['placeholder' => 'Téléphone', 'class' => 'form-control']) }}
	    	{!! $errors->first('tel', '<small class="help-block">:message</small>') !!}
        </td>
    </tr>

	<tr>
	    <td>{{ Form::label('fax', "Télécopieur") }}</td>
	    <td class="{!! $errors->has('fax') ? 'has-error' : '' !!}">
	    	{{ Form::text('fax', null, ['placeholder' => 'Télécopieur', 'class' => 'form-control']) }}
	    	{!! $errors->first('fax', '<small class="help-block">:message</small>') !!}
        </td>
    </tr>

	<tr>
	    <td>{{ Form::label('website', "Site web") }}</td>
	    <td class="{!! $errors->has('website') ? 'has-error' : '' !!}">
	    	{{ Form::text('website', null, ['placeholder' => 'Site Web', 'class' => 'form-control']) }}
	    	{!! $errors->first('website', '<small class="help-block">:message</small>') !!}
        </td>
    </tr>
</table>

{!! Recaptcha::render() !!}<br>

<p>
	{{Form::checkbox('news', 'true')}} 	 {{ Form::label('news', "Recevoir les newsletters et les offres ?", ['class' => "control-label"]) }}
</p>

{!! Form::submit('Inscription', ['class' => 'button mid-width btn-medium']) !!} {!!
Form::close() !!} 
    <div class="seperator"></div>
    <p>Déjà inscrit ? {{link_to_route('auth.login', 'Connectez-vous !', [], ['class' => 'link'])}}</p>

@stop

@section('js')
{!! JsValidator::formRequest('App\Http\Requests\UserCreateRequest', '#inscription'); !!}
	{{ Html::script("js/selectize.js")}}
    {{ Html::script("js/search-engine.js")}}
    {{ Html::style("css/selectize.css")}}
    <script type='text/javascript'>
$(document).ready(function() {
  $('#search-engine-location').searchEngine();

  function displayDetails() {
  	$(".type-detail").each(function() {
  		$(this).removeClass('hidden').addClass('hidden');
  	});

  	$("#type-"+$('#type').val()).removeClass('hidden');
  }

  $('#type').on('change', function() {
  	  displayDetails();
  });

  displayDetails();
});
</script>
@stop

