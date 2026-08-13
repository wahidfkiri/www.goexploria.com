@extends('layouts.back.master-with-left-menu')
@section('title', 'Pages des établissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.page.edit', $company, $page) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
	<h4>Editer la page {{$page->name}} de {{ $company->name}}</h4>
		<div class="row">
			<div class="col-md-12">

				<div class="panel-body">

					 {{ Form::open(array('route' => array('company.page.edit.post',  $company->id, $page->id), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered', 'files' => true)) }}

					{{ Form::label('name', "Titre", ['class' => "control-label"]) }}
	                {{ Form::text('name', $page->name, ['class' => 'form-control', 'placeholder' => 'Titre']) }}

	                <br>

					{{ Form::label('rank', "Rang", ['class' => "control-label"]) }}
	                {{ Form::number('rank', $page->rank, ['class' => 'form-control', 'min'=>0, 'placeholder' => 'Rang']) }}

	                <br>

          {{ Form::label('parent', "Parent", ['class' => "control-label"]) }}
                  {{ Form::select('parent',$pages, $parent, ['placeholder' => "Choisir la page parent ..."])  }}

                  <br>

          {{ Form::label('logo', "Photo du méga menu (valable pour thème avec megamenu seulement)", ['class' => "control-label"]) }}
                  <p style="font-size:15px;">Taille optimale de 200px par 200px ou une image de 1920px par la hauteur désirée.</p>
                  <input name="logo" type="file" accept=".jpg, .png, .jpeg, .svg">
          @if ($page->logo_url)
            <img class="img-responsive" style="width:unset" src="{{ $logo_path . $page->logo_url }}">
          @endif

                  <br>

          {{ Form::label('external_link', "Lien externe", ['class' => "control-label"]) }}
                  {{ Form::text('external_link', $page->external_link, ['class' => 'form-control', 'placeholder' => 'Lien externe']) }}

                  <br>
          {{ Form::label('content', "Contenu", ['class' => "control-label"]) }}

    	                {!! Form::textarea('content', $page->content, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) !!}

              <p> Cette page est utilisé comme conteneur.  Elle ne peut donc pas avoir de contenu.  Si elle en à déjà eu, l'ancien contenu a été conservé. </p>
              <h2>Liste des pages enfants</h2>
              <ul>
                @foreach ( $page->children as $child )
                  <li><a href="/admin/company/page/mod/{{ $company->id }}/{{ $child->id }}/edit">{{ $child->name }}</a></li>
                @endforeach
              </ul>
<br>
                    {{ Form::label('language', "Langue*", ['class' => "control-label"]) }}
                    {!!Form::select('language', $languages, $page->language, ['class' => 'form-control'])!!}
	                <br>
					{{ Form::label('is_home', "Est la page d'accueil?", ['class' => "control-label"]) }}
					{{ Form::checkbox('is_home', null, $page->is_home) }}<br>
					<i>Si la case est cochée, ces champs ne seront pas pris en compte sur le site : Titre, Rang, Parent, Photo du mégamenu, Lien externe.</i>
					<br>
					<br>
					<br>
					{{ Form::submit('Modifier') }}
	                {{ Form::close() }}

				</div>

			</div>
		</div>

@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\PageRequest', '#addForm'); !!}
@stop
