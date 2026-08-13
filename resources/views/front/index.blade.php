@extends('layouts.front.master')
@section('title', 'Accueil')
@section('bodyclass', 'home-page')
@section('content')
       <!-- Sliders -->
@if( isset($galleries_slider) )
    @if( $galleries_slider->count() > 0 )
        <div id="carousel_home" class="carousel slide" data-ride="carousel">

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <?php $itemIndex=0; ?>
                @foreach( $galleries_slider as $gallery)
                    @foreach( $gallery->medias->sortBy('rank') as $l => $media)
                        <div class="item @if ($itemIndex === 0) active @endif @if (!$media->photo) carousel-has-video @endif"
                                @if ($media->photo)
                                    style="background-image: url({!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!});"
                                @endif
                            >
				 
                            @if ($media->target != '')
                                <a target="_blank" href="{{ $media->target }}">
                                    @endif
                                    @if ($media->photo)
                                        <!--<img alt="{{ $media->name }}" title="{{ $media->name }}" src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}" alt="{{ $media->id }}">-->
                                    @else
                                        @if (App\Helpers\Formatter::getVideoType($media->slug) == 'youtube')
                                            <iframe class="carousel-video" src="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>
                                        @elseif (App\Helpers\Formatter::getVideoType($media->slug) == 'vimeo')
                                            <img src="{{ App\Helpers\Formatter::getVimeoMiniature($media->slug, 'large') }}">
                                        <!--<iframe class="carousel-video" src="{{ App\Helpers\Formatter::getVimeoEmbed($media->slug) }}" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>-->
                                        @endif

                                        <!-- Button HTML (to Trigger Modal) -->
                                        <a href="#homeModal{{ $media->id }}" class="video-carousel-modal-btn" data-toggle="modal"></a>

                                    @endif
                                    @if ($media->target != '')</a>@endif
				
                            <style>
                                body.home-page .carousel-caption a {
                                    position: static !important;
                                }
                            </style>
                                    <div class="carousel-caption">
                                        <h1>{{ $media->name }}</h1>
                                        <h4>@if( $media->content != '' ) {{ $media->content }} @endif</h4>
                                        @if( strlen($media->target) > 0 ) <h4><a href="{{ $media->target }}" target="_blank">En savoir plus &gt;</a></h4>@endif
                                    </div>
                        </div>
                        <?php $itemIndex++; ?>
                    @endforeach
                @endforeach
            </div>

            <!-- Indicators -->
            <ol class="carousel-indicators">
                @for ($i = 0; $i < $itemIndex; $i++)
                    <li data-target="#carousel_home" data-slide-to="{{ $i }}" class="@if ($i === 0) active @endif"></li>
                @endfor
            </ol>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel_home" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel_home" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <!-- Modal HTML -->
        <?php $itemIndex=0; ?>
        @foreach( $galleries_slider as $gallery)
            @foreach( $gallery->medias->sortBy('rank') as $l => $media)
                <div id="homeModal{{ $media->id }}" class="modal fade">
                    <div class="modal-dialog video-carousel-modal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="video-modal-body">

                                @if (App\Helpers\Formatter::getVideoType($media->slug) == 'youtube')
                                    <iframe class="video-modal-frame" src="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}" allowfullscreen="" frameborder="0"></iframe>
                                @elseif (App\Helpers\Formatter::getVideoType($media->slug) == 'vimeo')
                                    <iframe class="video-modal-frame" src="{{ App\Helpers\Formatter::getVimeoEmbed($media->slug) }}" allowfullscreen="" frameborder="0"></iframe>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <?php $itemIndex++; ?>
            @endforeach
        @endforeach
    @endif
@endif


<section id="content">
    <!-- Popular Destinations -->

    <div class="home destinations section">
        <div class="container">


{{--  #how to fix video : https://stackoverflow.com/questions/18241569/bootstrap-carousel-pause-when-youtube-video-played --}}


            <div class="home-page-intro">
                {!! $config_content->home_intro !!}
            </div>

          <div id="home_news">
            <!-- Entreprises en vedette -->
        		@if( $vedette_companies->count() > 0 )
            <h2 class="separator">Établissements en vedette</h2>
              <ul id="company_listing">
              @foreach( $vedette_companies as $i => $company)
  		          <li>
  		            <a href="{{ url('company/'.$company->id.'/'.$company->slug) }}" >{{ $company->name }}</a>
  		            <span class="activity">@if( !empty($company->activities->first()['name']) ) {{ '-&gt; ' . $company->activities->first()['name'] }} @endif</span>
  		          </li>
      		    @endforeach
        		  </ul>
            @endif
          </div>

          <!-- Différentes galeries aléatoires de différentes destinations, pays et entreprises -->
          @if( $galleries->count() > 0 )
          <h2 class="separator">Galeries en vedette</h2>

            <div id="medias-photo-tab" class="tab-pane">
              <?php $last_gallery_id = 0; ?>

              @foreach( $galleries as $i => $gallery)
                @foreach( $gallery->medias->sortBy('rank') as $l => $media)

      		        <?php

    		            $author = !empty($media->content) ? '<br>' . $media->content : '';

    		            $media_title = $media->name;

    		            if( !empty($media->target) ) {
      		            preg_match("/[a-z0-9\-]{1,63}\.[a-z\.]{2,6}$/", parse_url($media->target, PHP_URL_HOST), $domain);
                      $media_title = '<a title="Cliquez pour en savoir plus sur '.@$domain[0].'" target="_blank" href="'.$media->target.'">'.$media->name.' &nbsp; <i class="fa fa-external-link" aria-hidden="true"></i></a>';
                    }

    		          ?>
      		        @if( $gallery->id != $last_gallery_id )
      		          <?php
      		            $last_gallery_id = $gallery->id;
      		          ?>
      		          <div class="media">
                          @if ($media->photo)
            		          <a data-toggle="lightbox" data-gallery="gallery-{{ $gallery->slug }}" data-type="image" class="hover-effect" data-title="{{ $media_title . $author }}" href="#" data-remote="{!! URL::asset('uploads/galleries/' . $gallery->id . '/'. $media->slug) !!}">
                                  <img class="img-fluid" alt="{{ $media->name }}" src="{!! URL::asset('uploads/galleries/' . $gallery->id . '/' . $media->slug) !!}" alt="{{ $media->name }}" title="{{ $media->name }}">
                              </a>
                          @else
                              @if (App\Helpers\Formatter::getVideoType($media->slug) == 'youtube')
                                  <a data-toggle="lightbox" data-gallery="gallery-{{ $gallery->slug }}" class="hover-effect" data-title="{{ $media_title . $author }}" href="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}">
                                      <img class="img-fluid" alt="{{ $media->name }}" src="{{ App\Helpers\Formatter::getYoutubeMiniature($media->slug) }}" alt="{{ $media->name }}" title="{{ $media->name }}">
                                  </a>
                              @elseif (App\Helpers\Formatter::getVideoType($media->slug) == 'vimeo')
                                  <a data-toggle="lightbox" data-gallery="gallery-{{ $gallery->slug }}" class="hover-effect" data-title="{{ $media_title . $author }}" href="{{ App\Helpers\Formatter::getVimeoEmbed($media->slug) }}">
                                      <img class="img-fluid" alt="{{ $media->name }}" src="{{ App\Helpers\Formatter::getVimeoMiniature($media->slug, 'large') }}" alt="{{ $media->name }}" title="{{ $media->name }}">
                                  </a>
                              @endif
                          @endif
            		      <div class="caption">
            						<h3 class="title">{{ isset($gallery->lname) ? $gallery->lname : ( isset($gallery->cname) ? $gallery->cname : ( isset($gallery->ename) ? $gallery->ename : '' ) ) }}</h3>
            						<h5>{{ $gallery->name }}</h5>
            		      </div>

            		    </div>
            		  @else
            		    {{-- Les autres photos de la même galerie photos --}}
                          @if ($media->photo)
            		          <a style="display: none;" data-title="{{ $media_title . $author }}" data-toggle="lightbox" data-gallery="gallery-{{ $gallery->slug }}" data-type="image" data-remote="{!! URL::asset('uploads/galleries/' . $gallery->id . '/'. $media->slug) !!}"></a>
                          @else

                                @if (App\Helpers\Formatter::getVideoType($media->slug) == 'youtube')
                                    <a style="display: none;" data-title="{{ $media_title . $author }}" data-toggle="lightbox" data-gallery="gallery-{{ $gallery->slug }}" href="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}"></a>
                                @elseif (App\Helpers\Formatter::getVideoType($media->slug) == 'vimeo')
                                    <a style="display: none;" data-title="{{ $media_title . $author }}" data-toggle="lightbox" data-gallery="gallery-{{ $gallery->slug }}" href="{{ App\Helpers\Formatter::getVimeoEmbed($media->slug) }}"></a>
                                @endif
                          @endif
      		        @endif

        		    @endforeach
      		    @endforeach

    		    </div>
          @endif


            <div class="home-page-outro">
                {!! $config_content->home_outro !!}
            </div>


@stop
@section('js')

{{ Html::style('css/revolution/style.css') }}
{{ Html::script('js/revolution/min.js') }}

<script type='text/javascript'>
$(document).ready(function() {
  /*
  var $item = $('.carousel .item');
  var $wHeight = $(window).height();
  $item.eq(0).addClass('active');
  $item.height($wHeight);
  $item.addClass('full-screen');
  */

  /*
  $('.carousel img').each(function() {
    var $src = $(this).attr('src');
    var $color = $(this).attr('data-color');
    $(this).parent().css({
      'background-image' : 'url(' + $src + ')',
      'background-color' : $color
    });
    $(this).remove();
  });

  $(window).on('resize', function (){
    $wHeight = $(window).height();
    $item.height($wHeight);
  });
  */

  $('.revolution-slider').revolution(
  {
      dottedOverlay:"none",
      delay:8000,
      startwidth:1170,
      startheight:380,
      onHoverStop:"on",
      hideThumbs:10,
      fullWidth:"on",
      forceFullWidth:"on",
      navigationType:"none",
      shadow:0,
      spinner:"spinner4",
      hideTimerBar:"off",
  });
});

</script>

<style type="text/css">
  .home-page .carousel {
    width: 60%;
  }

  .home-page .carousel .item {
    max-height: 306px; /* 380px */
  }

  .home-page .carousel .item img {
    min-width: 100%;
  }

  .home-page section#content .home .container {
    position: relative;
  }

  #home_news {
    width: 39%;
    position: absolute;
    right: 0px;
    top: 0px;
    margin-top:-7px;
    padding: 3px 10px;
  }

  #home_news h2 {
    margin: 4px 0 1px 0;
  }

  #home_news .media {
    max-height: 255px;

  }

  #home_news .media img {
    width: 100%;
    max-width: 100%;
    max-height: 255px;
  }

  #company_listing {
    height: 255px;
    margin: 0;
    padding: 0;
  }

  #company_listing li {
   height: 20%;
   line-height: 21px;
   background-color: #f6f6f6;
   padding-top:3px;
  }

  #company_listing li:nth-of-type(odd) {
    background-color: #e5e5e5;
  }

  #company_listing li a {
    font-size: 1.3em;
    color: #07889b;
    padding: 0 20px;
    display: block;
  }

  #company_listing li a:hover {
    color: #222;
  }

  #company_listing .activity {
    padding: 0 20px;
    font-size: 1.2em;
    color: #333;
  }

  #medias-photo-tab .media img {
    max-height: none;
  }

</style>

@stop
