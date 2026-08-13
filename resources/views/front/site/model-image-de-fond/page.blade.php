@include("front.gallery")
@extends('layouts.front.site.' . $theme . '.master-with-breadcrumb')
@section('title', isset($company->name) ? ucfirst(Formatter::remove_accents($company->name)) : "Site")
<div class="container">
{{--@section('breadcrumb-title')
    {{ strtoupper(Formatter::remove_accents($company->name)) }}
@stop --}}

@section('breadcrumb')
    <ol class="breadcrumb">
			<li><a href="{!! url($company_domain) !!}">Accueil</a></li>
  		<li class="active">{{ $page->name }}</li>
		</ol>
@stop
</div>
@section('main-content')
<div class="container">
<div class="row">

  <div id="main" class="col-md-12">

	  <div class="" id="main-content">

      <!-- Pages -->
      @if( isset($page) )
        @if( $page->slug == 'contact' )

          <h1>Pour nous joindre</h1>
          <address class="pull-left">
          @if (isset($company->coordinate->adresse))
              {{$company->coordinate->adresse}}<br>
          @endif
          @if (isset($company->coordinate->location->name))
              {{$company->coordinate->location->name}}
          @endif
          @if (isset($company->coordinate->code_postal))
              {{$company->coordinate->code_postal}}
          @endif
          @if (isset($company->coordinate->location->country->name))
              <br>{{$company->coordinate->location->country->name}}
          @endif
          <br><br>
          </address>

          <address class="pull-right">
          @if (isset($company->coordinate->tel))
              Tél.: {{$company->coordinate->tel}}<br>
          @endif
          @if (isset($company->coordinate->fax))
              Fax : {{$company->coordinate->fax}}<br>
          @endif
          @if (isset($company->coordinate->mail))
              <a href="mailto:{{$coordinate->mail}}">{{$company->coordinate->mail}}</a><br>
          @endif
          @if (isset($company->coordinate->website))
              <a href="{{$coordinate->website}}" target="_blank">{{$company->coordinate->website}}</a><br>
          @endif
        </address>

          <!-- Carte -->
          <div id="map-tab" class="tab-pane fade in active">
              <iframe class="carte" src="https://maps.google.com/maps?q={{ str_replace(' ', '+', $company->coordinate->adresse).','.$company->location->name }}&amp;num=1&amp;ie=UTF8&amp;t=m&amp;output=embed"></iframe>
          </div>
        @else
          {!! $page->content !!}

          <div class="gallery">
            @if( ! $page->galleries()->get()->isEmpty() )

              @yield("gallery")
            @endif
          </div>

        @endif
     @endif

    </div>
  </div>
</div>
</div>
@stop
@section('js')

  <script type="text/javascript" >
  jQuery(document).ready(function(){

    $('#signupForm').submit(function (e) {
    	if( $(this).find('#email').val() == '' ) {
    		e.preventDefault();
    		alert('Erreur: veuillez entrer votre adresse courriel valide.');
    	}
    });

  });
  </script>

  <style type="text/css">
    .carousel .item {
      height: 380px !important;
    }
    address {
      color: #333;
      font-size: 1.2em;
    }
    .page_content_container{
      padding: 15px;
    }
    .btn-dark {
      background-color: #888 !important;
      color: #fff !important;
    }

    li .btn-dark:hover {
      background-color: #01b7f2 !important;
      color: #fff !important;
    }
    li.active .btn-dark {
      background-color: #01b7f2 !important;
      color: #fff !important;
    }
  </style>

@stop
