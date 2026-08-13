@extends('layouts.back.master')
@section('title', "Ajout d'utiliateurs")
@section('content')
{!! Breadcrumbs::render('user.add') !!}
<h3>Ajouter un utilisateur</h3>

 {!! Form::open(['route' => 'user.add.post', 'method' => 'post', 'id'=>'inscription']) !!}
<!-- Info relative au site -->
<div class="seperator"><label>Profil</label></div>
<table class='table user'>

	<tr>
		<td>{!! Form::label('mail', 'Email*') !!}</td>
		<td class="{!! $errors->has('mail') ? 'has-error' : '' !!}">
			{!! Form::text('mail', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
			{!! $errors->first('mail', '<small class="help-block">:message</small>') !!}
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
  <tr>
    <td>{!! Form::label('entreprise', 'entreprise') !!}</td>
    <td>{!! Form::text('entreprise', null, ['placeholder' => 'Entreprise', 'class' => 'form-control typeahead']) !!}</td>
  </tr>
</table>
<input type="hidden" name="company_id" value="null" id="company_id">


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
		<td>{!! Form::label('last_name', 'Nom') !!}</td>
		<td class="{!! $errors->has('last_name') ? 'has-error' : '' !!}">
			{!! Form::text('last_name', null, ['placeholder' => 'Nom', 'class' => 'form-control']) !!}
			{!! $errors->first('last_name', '<small class="help-block">:message</small>') !!}
		</td>
	</tr>
	<tr>
		<td>{!! Form::label('first_name', 'Prénom') !!}</td>
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

<p>
{{Form::checkbox('rang', 'true')}} <td>{{ Form::label('rang', "Administrateur ?") }}
</p>

<p>
{{Form::checkbox('activation', 'true')}} <td>{{ Form::label('activation', "Actif ?") }}
</p>

<p>
	{{Form::checkbox('news', 'true')}} 	 {{ Form::label('news', "Recevoir les newsletters et les offres ?", ['class' => "control-label"]) }}
</p>

{!! Form::submit('Créer', ['name' => 'create', 'class' => 'btn']) !!}
{!! Form::submit('Créer et continuer', ['name' => 'continue', 'class' => 'btn']) !!}
{!!
Form::close() !!}
@stop

@section('css')
@parent
<style>
.tt-menu {
  width: 422px;
  margin: 12px 0;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
  -moz-border-radius: 8px;
  border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
  -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
  box-shadow: 0 5px 10px rgba(0,0,0,.2);
}
</style>
@stop
@section('js')
	{!! JsValidator::formRequest('App\Http\Requests\AdminUserCreateRequest', '#inscription'); !!}
	{{ Html::script("js/selectize.js")}}
    {{ Html::script("js/search-engine.js")}}
    {{ Html::style("css/selectize.css")}}
    <script src="/js/typeahead.bundle.min.js"></script>
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

  ////////////////////////////
  // typeahead (autocomplete)
  ////////////////////////////
  const companies = {!! json_encode($companies) !!};
  var substringMatcher = function(strs) {
    return function findMatches(q, cb) {
      var matches, substringRegex;

      // an array that will be populated with substring matches
      matches = [];

      // regex used to determine if a string contains the substring `q`
      substrRegex = new RegExp(q, 'i');

      // iterate through the pool of strings and for any string that
      // contains the substring `q`, add it to the `matches` array
      $.each(strs, function(i, obj) {
        if (substrRegex.test(obj.name)) {
          matches.push(obj);
        }
      });

      cb(matches);
    };
  };
  $('.typeahead').typeahead({
    hint: true,
    highlight: true,
    minLength: 1
  },
  {
    name: 'company',
    source: substringMatcher(companies),
    display: 'name',
  }).bind('typeahead:select',function(ev, suggestion) {
    $('input[name="company_id"]').val(suggestion.id);
  }).bind('typeahead:change',function(ev, suggestion) {
    if( suggestion  === "") {
      $('input[name="company_id"]').val("");
    }

  });
});
</script>
@stop
