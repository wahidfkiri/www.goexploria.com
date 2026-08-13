@include("front.gallery")
@extends('layouts.front.site.' . $theme . '.master')

@section('title', isset($company->name) ? ucfirst(Formatter::remove_accents($company->name)) : "Site")

@section('breadcrumb-title')
    {{ strtoupper(Formatter::remove_accents($company->name)) }}
@stop

@section('breadcrumb')
    {{-- {!! Breadcrumbs::render('front.site', $company) !!} --}}
@stop

@section('main-content')

<div class="row">

  <div id="main" class="col-md-12">

    <div class="" id="main-content">
      <!-- Sliders -->
  		@if( isset($medias) )
  		  @if( $medias->where('gslider', 1)->count() > 0 )
          <div id="carousel_index" class="carousel slide col-xs-12 col-sm-12 col-md-12 col-lg-12" data-ride="carousel">
      		  <!-- Indicators -->
        		  <ol class="carousel-indicators">
        		      @for ($i = 0; $i < $medias->where('gslider', 1)->count(); $i++)
                      <li data-target="#carousel_index" data-slide-to="{{ $i }}" class="@if ($i === 0) active @endif"></li>
                  @endfor
        		  </ol>

        		  <!-- Wrapper for slides -->
        		  <div class="carousel-inner" role="listbox">
        		    <?php $itemIndex=0; ?>
        		    @foreach( $medias->where('gslider', 1) as $media)

                  <div class="item @if ($itemIndex === 0) active @endif">
          		      @if ($media->target != '')
                      <a target="_blank" href="{{ $media->target }}">
                    @endif
                    @if ($media->photo)
                      <img alt="{{ $media->name }}" title="{{ $media->name }} - {{ strtoupper($company->name) }}"
                        src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}" alt="{{ $media->id }}">
                      @if ($media->target != '')</a>@endif
                    @else
                      <iframe class="carousel-video" src="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>

                    @endif


                    <div class="carousel-caption">
          						@if(strlen($media->name) > 0) <h1>{{ $media->name }}</h1> @endif
          						@if( strlen($media->content) > 0)<h4>{{ $media->content }}</h4>  @endif
          						@if( strlen($media->target) > 0 ) <h4><a href="{{ $media->target }}" target="_blank">En savoir plus &gt;</a></h4>@endif
          		      </div>
          		    </div>
          		    <?php $itemIndex++; ?>
        		    @endforeach

        		  </div>

        		  <!-- Controls -->
        		  <a class="left carousel-control" href="#carousel_index" role="button" data-slide="prev">
        		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        		    <span class="sr-only">Previous</span>
        		  </a>
        		  <a class="right carousel-control" href="#carousel_index" role="button" data-slide="next">
        		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        		    <span class="sr-only">Next</span>
        		  </a>
      		</div>
  		  @endif
  		@endif

      <div class="clearfix"></div>

      <!-- Medias -->

      @if (isset($medias) && $medias->where('gslider', null)->count() > 0 )

        <!--<h2 class="separator">Galeries</h2>-->
        @yield('gallery')
      @endif

      <!-- Tourisme -->
      <!--@if (isset($activities) && $activities->where('type_id', 1)->count() > 0)
      <div id="tourisme-tab" class="tab-pane">
          <table class='table table-striped'>
              <tr>
                  <th>Activité</th>
                  <th>Catégorie</th>
              </tr>
              @foreach($activities->where('type_id', 1)->sortBy('category_name')->all() as $activity)
                  <tr>
                      <td>{{$activity->name}}</td>
                      <td>{{$activity->category_name}}</td>
                  </tr>
              @endforeach
          </table>
      </div>
      @endif-->

      <!-- Affaire -->
      @if (isset($activities) && $activities->where('type_id', 2)->count() > 0)
      <div id="affaire-tab" class="tab-pane">
          <table class='table table-striped'>
              <tr>
                  <th>Activité</th>
                  <th>Catégorie</th>
              </tr>
              @foreach($activities->where('type_id', 2)->sortBy('category_name')->all() as $activity)
                  <tr>
                      <td>{{$activity->name}}</td>
                      <td>{{$activity->category_name}}</td>
                  </tr>
              @endforeach
          </table>
      </div>
      @endif

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

    #carousel_index .item img {
      min-width: 75%;
    }

  </style>

@stop
