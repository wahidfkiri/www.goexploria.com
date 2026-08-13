@include("front.gallery")

@extends('layouts.front.master-with-breadcrumb')
@section('title', isset($company->name) ? ucfirst(Formatter::remove_accents($company->name)) . "| ENTREPRISE" : "Entreprise")

@section('breadcrumb-title')
    {{ strtoupper(Formatter::remove_accents($company->name)) }}
@stop

@section('breadcrumb')
    {!! Breadcrumbs::render('front.company', $company) !!}
@stop

@section('main-content')

<div class="row">
  <div class="sidebar col-md-3">
  @if( isset($company_logo) && !empty($company_logo) )
    <div id="logo_company">
      <img src="{{ URL::asset('uploads/companies/'.$company->id.'/' . $company_logo) }}" alt="Logo {{ $company->name }}">
    </div>
  @endif
  <div class="company-social-icon-wrapper">
      @if ($company->socialNetworks)
          @if ($company->socialNetworks->facebook)
              <a href="{{ $company->socialNetworks->facebook }}" target="_blank" class="company-social-icon icon fa fa-2x fa-facebook"></a>
          @endif
          @if ($company->socialNetworks->twitter)
              <a href="{{ $company->socialNetworks->twitter }}" target="_blank" class="company-social-icon icon fa fa-2x fa-twitter"></a>
          @endif
          @if ($company->socialNetworks->youtube)
              <a href="{{ $company->socialNetworks->youtube }}" target="_blank" class="company-social-icon icon fa fa-2x fa-youtube-play"></a>
          @endif
          @if ($company->socialNetworks->pinterest)
              <a href="{{ $company->socialNetworks->pinterest }}" target="_blank" class="company-social-icon icon fa fa-2x fa-pinterest-p"></a>
          @endif
          @if ($company->socialNetworks->instagram)
              <a href="{{ $company->socialNetworks->instagram }}" target="_blank" class="company-social-icon icon fa fa-2x fa-instagram"></a>
          @endif
          @if ($company->socialNetworks->linkedin)
              <a href="{{ $company->socialNetworks->linkedin }}" target="_blank" class="company-social-icon icon fa fa-2x fa-linkedin-square"></a>
          @endif
          @if ($company->socialNetworks->google_plus)
              <a href="{{ $company->socialNetworks->google_plus }}" target="_blank" class="company-social-icon icon fa fa-2x fa-google-plus"></a>
          @endif
          @if ($company->socialNetworks->reddit)
              <a href="{{ $company->socialNetworks->reddit }}" target="_blank" class="company-social-icon icon fa fa-2x fa-reddit"></a>
          @endif
      @endif
  </div>
      <div class="company-social-icon-wrapper" style="position: relative;">
          @if (!empty($pictos))
              @foreach ($pictos as $keyPicto => $picto)
                  @if (!empty($picto['url']))
                      <a href="{{ $picto['url'] }}" target="_blank" class="company-social-icon icon">
                          <img src="{{ url('/') }}/uploads/pictos/{{ $picto['image'] }}" alt="{{ $picto['name'] }}" style="width: auto; max-height: 72px;">
                          @if (!empty($picto['name']))
                              <div class="social-hover-text">{{ $picto['name'] }}</div>
                          @endif
                      </a>
                  @else
                      <a class="company-social-icon icon">
                          <img src="{{ url('/') }}/uploads/pictos/{{ $picto['image'] }}" alt="{{ $picto['name'] }}" style="width: auto; max-height: 72px;">
                          @if (!empty($picto['name']))
                              <div class="social-hover-text">{{ $picto['name'] }}</div>
                          @endif
                      </a>
                  @endif
              @endforeach
          @endif
      </div>

  <h3 class="top-sidebar">{{ $company->name }}</h3>

    <article class="widget detailed-logo">
      <!-- Coordonnées -->
      @if( isset($coordinate) && count_of($coordinate) > 0 )
        <h5>Contact</h5>
        <address>
          @if (isset($coordinate->adresse))
              {{$coordinate->adresse}}<br>
          @endif
          @if (isset($coordinate->location->name))
              {{$coordinate->location->name}}
          @endif
          @if (isset($coordinate->code_postal))
              {{$coordinate->code_postal}}
          @endif
          @if (isset($coordinate->location->country->name))
              <br>{{$coordinate->location->country->name}}
          @endif
          <br><br>
          @if (isset($coordinate->tel))
              {{$coordinate->tel}}<br>
          @endif
          @if (isset($coordinate->fax))
              F. {{$coordinate->fax}}<br>
          @endif
          @if (isset($coordinate->mail))
              <a href="mailto:{{$coordinate->mail}}" target="_blank">{{$coordinate->mail}}</a><br>
          @endif
          @if (isset($coordinate->website))
              <a href="{{$coordinate->website}}" target="_blank">{{$coordinate->website}}</a><br>
          @endif
        </address>
      @endif

	  </article>

      @if ($company->newsletter == 0)
        <article class="widget detailed-infolettre">
          <h2 style="margin-bottom: 0">Infolettre</h2>
          <p>Inscription à l'infolettre de l'entreprise</p>
          {{ Form::open(array('route' => array('front.company.newsletter.subscribe', Formatter::slugWithId($company->slugify())), 'method' => 'POST', 'id' => 'signupForm', 'class' => 'form-horizontal form-groups-bordered', 'autocomplete' => 'off')) }}
            {{ Form::text('email', null, ['class' => 'form-control', 'min'=>0, 'placeholder' => 'Votre adresse courriel...', 'id' => 'email']) }}
            <br>
            {!! Form::submit('S\'abonner à l\'infolettre', array('class'=>'send-btn')) !!}
          {{ Form::close() }}
        </article>
      @endif



      @if( isset($pubs_slider) )
          @if( $pubs_slider->count() > 0 )
              <article class="detailed-logo">
                  <h2>Espace pub</h2>
                  <div id="carousel_home" class="pub-carousel carousel slide" data-ride="carousel">

                      <!-- Wrapper for slides -->
                      <div class="carousel-inner" role="listbox">
                          <?php $itemIndex=0; ?>
                          @foreach( $pubs_slider as $gallery)
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
                                                  <a href="#homeModal{{ $itemIndex }}" class="video-carousel-modal-btn" data-toggle="modal"></a>

                                                  <!-- Modal HTML -->
                                                  <div id="homeModal{{ $itemIndex }}" class="modal fade">
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
                                              @endif
                                              @if ($media->target != '')</a>@endif

                                      @if ($media->photo)
                                          <div class="carousel-caption">
                                              @if( $media->name != '' )
                                                  <h1>{{ $media->name }}</h1>
                                              @endif
                                              @if( $media->content != '' )
                                                  <h4>{{ $media->content }}</h4>
                                              @endif
                                              @if( strlen($media->target) > 0 )
                                                  <h4><a href="{{ $media->target }}" target="_blank">En savoir plus &gt;</a></h4>
                                              @endif
                                          </div>
                                      @endif
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
              </article>
          @endif
      @endif


  </div>

  <div id="main" class="col-md-9">
      @if (isset($pagesLanguages) && !empty($pagesLanguages))
          @if (count_of($pagesLanguages) > 1)
              <div class="language-switcher">
                  <ul>
                      <li>
                          @if ($currentLanguage == 'Langues')
                              <span class="text-chevron"><img src="{{ URL::asset('images/drapeau.png') }}"></span> <span class="down-chevron">&rsaquo;</span>
                          @else
                              <span class="text-chevron"><img src="{{ URL::asset('images/drapeau.png') }}">{{ $currentLanguage }}</span> <span class="down-chevron">&rsaquo;</span>
                          @endif
                          <ul class="language-submenu">
                              @foreach ($pagesLanguages as $languageKey => $language)
                                  @if ($language['name'] != $currentLanguage)
                                      <li><a href="{{ $language['url'] }}" data-language="{{ $languageKey }}">{{ $language['name'] }}</a></li>
                                  @endif
                              @endforeach
                          </ul>
                      </li>
                  </ul>
                  <div class="clearboth"></div>
              </div>
          @endif
      @endif
    @if( isset($company_headImage) && !empty($company_headImage) )
      <div id="headImage">
          <img src="{{ URL::asset('uploads/companies/'.$company->id.'/'. $company_headImage) }}">
      </div>
    @endif

    <!-- Sliders -->
		@if( isset($medias) )
		  @if( $medias->where('gslider', 1)->count() > 0 )
   		  <div id="carousel_location" class="company-carousel carousel slide" data-ride="carousel">
    		  <!-- Indicators -->
      		  <ol class="carousel-indicators">
      		      @for ($i = 0; $i < $medias->where('gslider', 1)->count(); $i++)
                    <li data-target="#carousel_location" data-slide-to="{{ $i }}" class="@if ($i === 0) active @endif"></li>
                @endfor
      		  </ol>

      		  <!-- Wrapper for slides -->
      		  <div class="carousel-inner" role="listbox">
      		    <?php $itemIndex=0; ?>
      		    @foreach( $medias->where('gslider', 1) as $media)
        		    <div class="item @if ($itemIndex === 0) active @endif @if (!$media->photo) carousel-has-video @endif">
                  @if ($media->target != '')
                    <a target="_blank" href="{{ $media->target }}">
                  @endif
                  @if ($media->photo)
                    <img alt="{{ $media->name }}" title="{{ $media->name }} - {{ strtoupper($company->name) }}"
                      src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}" alt="{{ $media->id }}">
                    @if ($media->target != '')</a>@endif
                  @else


                      @if (App\Helpers\Formatter::getVideoType($media->slug) == 'youtube')
                          <iframe class="carousel-video" src="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>
                      @elseif (App\Helpers\Formatter::getVideoType($media->slug) == 'vimeo')
                          <img src="{{ App\Helpers\Formatter::getVimeoMiniature($media->slug, 'large') }}">
                          <!--<iframe class="carousel-video" src="{{ App\Helpers\Formatter::getVimeoEmbed($media->slug) }}" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>-->
                      @endif


                      <!-- Button HTML (to Trigger Modal) -->
                      <a href="#homeModal{{ $itemIndex }}" class="video-carousel-modal-btn" data-toggle="modal"></a>

                  @endif
        		      <div class="carousel-caption">
        						<h1>{{ $media->name }}</h1>
        						<h4>@if( $media->content != '' ) {{ $media->content }} @endif</h4>
        						@if( strlen($media->target) > 0 ) <h4><a href="{{ $media->target }}" target="_blank">En savoir plus &gt;</a></h4>@endif
        		      </div>
        		    </div>
        		    <?php $itemIndex++; ?>
      		    @endforeach

      		  </div>

      		  <!-- Controls -->
      		  <a class="left carousel-control" href="#carousel_location" role="button" data-slide="prev">
      		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      		    <span class="sr-only">Previous</span>
      		  </a>
      		  <a class="right carousel-control" href="#carousel_location" role="button" data-slide="next">
      		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      		    <span class="sr-only">Next</span>
      		  </a>
    		</div>
		  @endif
		@endif

      <!-- Modal HTML -->
          <?php $itemIndex=0; ?>
          @foreach( $medias->where('gslider', 1) as $media)
              <div id="homeModal{{ $itemIndex }}" class="modal fade">
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

	  <div class="tab-container style1" id="hotel-main-content">
        <ul class="tabs">


            <?php
                $homeContent = false;

                if (isset($pages)) {
                    foreach($pages as $key => $p) {
                        if ($p->is_home) {
                            if (!empty($p->content)) {
                                $homeContent = $p->content;
                            }
                        }
                    }
                }

                if (!$homeContent) {
                    if ($company->home_content) {
                        $homeContent = $company->home_content;
                    }
                }
            ?>

            @if ($homeContent || !empty($company->logo_gallery_checkbox))
                <li class="active"><a data-toggle="tab" href="#home-tab">Accueil</a></li>
            @endif

            @if ($homeContent || !empty($company->logo_gallery_checkbox))
                <li><a data-toggle="tab" href="#map-tab">Carte</a></li>
            @else
                <li class="active"><a data-toggle="tab" href="#map-tab">Carte</a></li>
            @endif

            @if (!empty($products))
                <li><a data-toggle="tab" href="#products-tab" class="tab-achats">Commande / Produits / Services</a></li>
            @endif
            {{-- <li >{{ link_to_route('front.company.newsletter.subscribe', "Inscription infolettre", Formatter::slugWithId($company->slugify()), ["target" => "_blank"])}}</li> --}}

                @if (isset($activities) &&  $activities->where('type_id', 1)->count() > 0)
                    <li><a data-toggle="tab" href="#tourisme-tab">Tourisme</a></li>
                @endif
                @if (isset($activities) &&  $activities->where('type_id', 2)->count() > 0)
                    <li><a data-toggle="tab" href="#affaire-tab">Affaire</a></li>
                @endif
                @if (isset($activities) &&  $activities->where('type_id', 3)->count() > 0)
                    <li><a data-toggle="tab" href="#local-tab">Local</a></li>
                @endif
                @if (isset($activities) &&  $activities->where('type_id', 4)->count() > 0)
                    <li><a data-toggle="tab" href="#primetime-tab">Prime Time</a></li>
                @endif
                @if (isset($activities) &&  $activities->where('type_id', 5)->count() > 0)
                    <li><a data-toggle="tab" href="#videos-tab">Web TV</a></li>
                @endif
                @if (isset($activities) &&  $activities->where('type_id', 6)->count() > 0)
                    <li><a data-toggle="tab" href="#photos-tab">Photos</a></li>
                @endif
                @if (isset($activities) &&  $activities->where('type_id', 7)->count() > 0)
                    <li><a data-toggle="tab" href="#forfaits-tab">Certificats Cadeaux Québec</a></li>
                @endif
                @if (isset($activities) &&  $activities->where('type_id', 8)->count() > 0)
                    <li><a data-toggle="tab" href="#produits-tab">Marketplace</a></li>
                @endif
                @if (isset($activities) &&  $activities->where('type_id', 9)->count() > 0)
                    <li><a data-toggle="tab" href="#plus-tab">Book Direct</a></li>
                @endif

            @if (isset($medias) && $medias->where('gslider', null)->count() > 0 )
              <?php $have_medias=true; ?>
                <li><a data-toggle="tab" href="#medias-photo-tab">Photos</a></li>
            @endif

            @if(isset($pages))
              <?php  foreach($pages as $key => $p): ?>
                <?php if (!$p->is_home) { ?>
                  <?php if( $p->parent != null ): continue;  endif; ?>
                  @php
                    $children = $p->children;
                  @endphp

                  @if( $children->count() == 0 )
                    <li>
                      <a data-toggle="tab" class="btn-dark" href="#page{{$p->id}}-tab">
                        {{$p->name}}
                      </a>
                    </li>
                  @else

                    <li class="dropdown" role="presentation">
                      <a
                        id="{{ "id-" . $p->slug }}"
                        class="dropdown-toggle btn-dark"
                        {{--
                          href="
                          @if( $p->content != null || $p->content != '' )
                            #page{{$p->id}}-tab
                          @else
                            #
                          @endif"
                        --}}
                        href="#page{{$p->id}}-tab"
                        data-target="#"

                        class="dropdown-toggle"
                        data-toggle="dropdown"
                        role="button"
                        aria-controls="{{ "id-" . $p->slug }}-contents" aria-expanded="false"
                      >
                        {{$p->name}}
                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu" id="{{ "id-" . $p->slug }}-contents" aria-labelledby="{{ "id-" . $p->slug }}">
                        @foreach($children as $k => $sp)
                          <li>
                            <a
                              id=""
                              href="#page{{ $sp->id }}-tab"
                              data-target="#page{{ $sp->id }}-tab"
                              role="tab"
                              data-toggle="tab"
                              aria-controls=""
                              aria-expanded="true"
                            >{{ $sp->name }}</a>
                          </li>
                        @endforeach
                      </ul>
                    </li>

                  @endif
                <?php } ?>
              <?php  endforeach; ?>
            @endif

        </ul>

        <div class="tab-content" id="destinations">
            @if ($homeContent || !empty($company->logo_gallery_checkbox))
                <!-- Home -->
                <div id="home-tab" class="tab-pane fade in active">

                    @if (!empty($company->logo_gallery_checkbox))
                        <div class="wrap-galerie company-slick-logos" style="margin-bottom: 12px;">
                            <!-- Logos -->
                            <?php
                                $logoSlider = $company->galleries->filter(function ($item) {
                                    return $item->is_carousel != 0;
                                });
                            ?>

                            @if( isset($logoSlider) )
                                @if( $logoSlider->count() > 0 )
                                    <section class="add_slider">
                                        <div class="center">
                                            @foreach( $logoSlider as $gallery)
                                                @foreach( $gallery->medias->sortBy('rank') as $l => $media)
                                                    <div class="">
                                                        <a target="_blank" href="{{ $media->target }}">
                                                            @if ($media->photo)
                                                                <img alt="{{ $media->name }}" title="{{ $media->name }} - {{ strtoupper($company->name) }}" src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}" alt="{{ $media->id }}">
                                                            @endif
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </section>
                                @endif

                                {{ Html::style('slick/slick.css') }}
                                {{ Html::style('slick/slick-theme.css') }}
                                {{ Html::script('slick/slick.js') }}
                                <script>
                                    jQuery(document).ready(function(){

                                        $('.add_slider > .center').slick({
                                            centerMode: true,
                                            centerPadding: '15px',
                                            slidesToShow: 6,
                                            responsive: [
                                                {
                                                    breakpoint: 768,
                                                    settings: {
                                                        arrows: false,
                                                        centerMode: true,
                                                        centerPadding: '40px',
                                                        slidesToShow: 3
                                                    }
                                                },
                                                {
                                                    breakpoint: 480,
                                                    settings: {
                                                        arrows: false,
                                                        centerMode: true,
                                                        centerPadding: '40px',
                                                        slidesToShow: 1
                                                    }
                                                }
                                            ]
                                        });
                                    });
                                </script>
                            @endif

                        </div>
                    @endif
                    {!! $homeContent !!}
                </div>
            @endif
            <!-- Carte -->
            @if ($homeContent || !empty($company->logo_gallery_checkbox))
                <div id="map-tab" class="tab-pane">
            @else
                <div id="map-tab" class="tab-pane fade in active">
            @endif
                <iframe class="carte"
                        src="https://maps.google.com/maps?q={{ str_replace(' ', '+', $company->coordinate->adresse).','.$company->location->name }}&amp;num=1&amp;ie=UTF8&amp;t=m&amp;output=embed">
                </iframe>

                <!-- Medias -->
                @if( isset($have_medias) )
                    <h2 class="separator">Galeries</h2>
                    @php
                    $current_page = "index";
                    @endphp
                    @yield("gallery")
                @endif
            </div>

                    @if (!empty($products))
                        <style>
                            #products-tab .invoice-table td {
                                width: 15%;
                            }
                            #products-tab .invoice-table td + td {
                                width: 40%;
                            }
                            #products-tab .invoice-table td + td + td {
                                width: 15%;
                            }
                            #products-tab .invoice-table td + td + td + td {
                                width: 15%;
                            }
                            #products-tab .invoice-table td + td + td + td + td {
                                width: 15%;
                            }
                        </style>
                        <div id="products-tab" class="tab-pane">
                            <form method="post" action="{{ route('front.company.print', [ $company->id, $company->slug ]) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @if (!empty(trim($company->achats_marche_a_suivre)))
                                    <div>
                                        <div style="font-size: 16px;">
                                            <p><strong>Marche à suivre :</strong></p>
                                            {!! $company->achats_marche_a_suivre !!}
                                        </div>
                                    </div>
                                @endif
                                <table>
                                    <tr>
                                        <td style="text-align: right"><strong>Nom complet : </strong></td>
                                        <td><input type="text" name="user[name]" value=""></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Compagnie : </strong></td>
                                        <td><input type="text" name="user[company]" value=""></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Adresse : </strong></td>
                                        <td><input type="text" name="user[address]" value=""></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Ville : </strong></td>
                                        <td><input type="text" name="user[city]" value=""></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Code postal : </strong></td>
                                        <td><input type="text" name="user[postalcode]" value=""></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Téléphone : </strong></td>
                                        <td><input type="text" name="user[phone]" value=""></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right"><strong>Courriel : </strong></td>
                                        <td><input type="text" name="user[email]" value=""></td>
                                    </tr>
                                </table>
                                <table class="invoice-table">
                                    <tr>
                                        <th>Photo</th>
                                        <th>Description</th>
                                        <th>Prix unitaire</th>
                                        <th>Quantité</th>
                                        <th>Coût</th>
                                    </tr>
                                    @foreach ($products as $keyProduct => $product)
                                        <tr>
                                            <td>
                                                @if (!empty($product['image']))
                                                    @if (!empty($product['url']))
                                                        <a href="{{ $product['url'] }}" target="_blank" style="width: auto; max-height: 100px; max-width: 100px;" data-type="image" class="hover-effect">
                                                            <img class="img-fluid" alt="{{ $product['name'] }}" src="{!! URL::asset('uploads/achats/' . $product['image']) !!}" title="{{ $product['name'] }}">
                                                        </a>
                                                    @else
                                                        <a data-toggle="lightbox" style="width: auto; max-height: 100px; max-width: 100px;" data-type="image" class="hover-effect" data-title="{{ $product['name'] }}" href="#" data-remote="{!! URL::asset('uploads/achats/' . $product['image']) !!}">
                                                            <img class="img-fluid" alt="{{ $product['name'] }}" src="{!! URL::asset('uploads/achats/' . $product['image']) !!}" title="{{ $product['name'] }}">
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ $product['name'] }}<input type="hidden" name="product[{{ $keyProduct }}][name]" value="{{ $product['name'] }}"></td>
                                            <td><span class="product-single-price" data-single="{{ $product['price'] }}">{{ number_format($product['price'], 2) }}</span>$</td>
                                            <td><input type="number" value="0" min="0" name="product[{{ $keyProduct }}][qty]"></td>
                                            <td style="text-align: right;"><span class="product-total-price" data-total="0">0.00</span>$</td>
                                        </tr>
                                    @endforeach
                                    @if (!empty($company->achats_frais_transport))
                                        <tr>
                                            <td colspan="4" style="text-align: right; font-weight: bold;">FRAIS DE TRANSPORT</td>
                                            <td style="text-align: right;"><span class="product-transport" data-transport="{{ $company->achats_frais_transport }}">{{ number_format(round($company->achats_frais_transport, 2), 2) }}</span>$</td>
                                        </tr>
                                    @endif
                                    @if (!empty($company->achats_frais_admin))
                                        <tr>
                                            <td colspan="4" style="text-align: right; font-weight: bold;">FRAIS D'ADMINISTRATION</td>
                                            <td style="text-align: right;"><span class="product-admin" data-admin="{{ $company->achats_frais_admin }}">{{ number_format(round($company->achats_frais_admin, 2), 2) }}</span>$</td>
                                        </tr>
                                    @endif
                                    @if (!empty($company->achats_reduction))
                                        <tr>
                                            <td colspan="4" style="text-align: right; font-weight: bold;">RÉDUCTION ({{ $company->achats_reduction }}%)</td>
                                            <td style="text-align: right;"><span class="product-rebate" data-reduction="{{ $company->achats_reduction }}">0.00</span>$</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="4" style="text-align: right; font-weight: bold;">SOUS-TOTAL</td>
                                        <td style="text-align: right;"><span class="product-subtotal">0.00</span>$</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right; font-weight: bold;">TPS 5,0%</td>
                                        <td style="text-align: right;"><span class="product-tps">0.00</span>$</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right; font-weight: bold;">TVQ 9,975%</td>
                                        <td style="text-align: right;"><span class="product-tvq">0.00</span>$</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right; font-weight: bold;">TOTAL</td>
                                        <td style="text-align: right;"><span class="product-total">0.00</span>$</td>
                                    </tr>
                                </table>
                                <!-- Versements -->
                                @if($company->versements)
                                    <table id="company_versements" data-versements="{{ $company->versements }}">
                                        @for($ctr = 0; $ctr < (int)$company->versements; $ctr++)
                                            <tr>
                                                <td style="text-align: right"><strong>Versement #{{ $ctr+1 }} : </strong></td>
                                                <td><input type="text" id="payment_price_{{ $ctr }}" name="user[payment][{{ $ctr }}][price]" value="" disabled="disabled"></td>
                                                <td style="text-align: right"><strong>Date du paiement : </strong></td>
                                                <td><input type="date" name="user[payment][{{ $ctr }}][date]"
                                                       value="<?php echo date('Y-m-d'); ?>"
                                                       min="<?php echo date('Y-m-d'); ?>"></td>
                                            </tr>
                                        @endfor
                                    </table>
                                @endif
                                @if($company->hide_facturation != true)
                                    <div style="text-align: center; padding-top: 24px; font-size: 16px;">
                                        <p>{{ $company->achats_note }}</p>
                                        <input type="submit" name="submit" value="Obtenir la facture à transmettre par courriel" style="
                                        background-color: #ef7724;
                                        color: #fff;
                                        font-weight: bold;
                                        border: 0;
                                        padding: 10px 20px;">
                                    </div>
                                @endif
                            </form>
                        </div>
                    @endif


            <!-- Pages -->
            @if(isset($pages))
                @foreach($pages as $key => $page)
                <div id="page{{$page->id}}-tab" class="tab-pane">
                    <div class="page_content_container">
                      <div class="content">
                        {!!$page->content!!}
                      </div>


                      <div class="gallery">
                        @if( ! $page->galleries()->get()->isEmpty() )

                          <div id="medias-photo-tab" class="tab-pane">
                            <?php $last_gallery_id = 0; ?>

                            <!-- IMPOSSIBLE D'UTILISÉ LA SECTION GALLERY.BLADE OU UNE AUTRE SEMBLABLE PCQ
                                  la variable $page tombe en dehors du scope -->

                            @foreach( $page_medias[$page->slug] as $i => $media)

                              @if( !$media->gslider )
                                <?php
                                  $author = !empty($media->content) && $media->photo == true ? '<br>' . $media->content : '';

                                  $media_title = $media->name;


                                  if( !empty($media->target) ) {
                                    preg_match("/[a-z0-9\-]{1,63}\.[a-z\.]{2,6}$/", parse_url($media->target, PHP_URL_HOST), $domain);
                        #            $media_title = '<a title="Cliquez pour en savoir plus sur '.$domain[0].'" target="_blank" href="'.$media->target.'">'.$media->name.' &nbsp; <i class="fa fa-external-link" aria-hidden="true"></i></a>';
                                    $media_title = '<a title="Cliquez pour en savoir plus" target="_blank" href="'.$media->target.'">'.$media->name.' &nbsp; <i class="fa fa-external-link" aria-hidden="true"></i></a>';
                                  }

                                ?>
                                @if($media->photo)
                                @if( $media->gid != $last_gallery_id )
                                  <?php
                                    $last_gallery_id = $media->gid;
                                  ?>
                                  <div class="media">

                                    {{-- http://ashleydw.github.io/lightbox/ --}}

                                      <a
                                        data-type="image"
                                        class="hover-effect"
                                        data-toggle="lightbox"
                                        data-gallery="gallery-{{ $media->gslug }}"
                                        data-title="{{ $media_title . $author }}"
                                        data-footer="
                                        @php
                                          if(isset($medias_attr[$media->id])) {
                                            echo htmlentities('<div class="attrs">');
                                              foreach($medias_attr[$media->id] as $attr) {
                                                echo htmlentities('<div class="attr">');
                                                echo $attr["attr"];
                                                echo htmlentities('</div>');
                                                echo htmlentities('<div class="value">');
                                                echo $attr["value"];
                                                echo htmlentities('</div>');
                                              }
                                            echo htmlentities('</div>');
                                          }
                                          if (!empty($media->code)) {
                                            echo htmlentities('<div class="bottom-gallery-footer">' . $media->code . '</div>');
                                          }
                                        @endphp"
                                        href="#"
                                        data-remote="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/'. $media->slug) !!}"
                                        >
                                          <img
                                            class="img-fluid"
                                            src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}"
                                            alt="{{ $media->name }}"
                                            title="{{ $media->name }} - {{ strtoupper($company->name) }}">
                                      </a>

                                      <div class="caption">
                                        <h5 class="title">{{ $media->gname }}</h5>
                                      </div>

                                  </div>
                                  @else
                                  {{-- Les autres photos de la même galerie photos --}}
                                  <a
                                    style="display: none;"
                                    data-type="image"
                                    data-title="{{ $media_title . $author }}"
                                    data-toggle="lightbox"
                                    data-gallery="gallery-{{ $media->gslug }}"
                                    data-footer="
                                    @php
                                      if(isset($medias_attr[$media->id])) {
                                        echo htmlentities('<div class="attrs">');
                                          foreach($medias_attr[$media->id] as $attr) {
                                            echo htmlentities('<div class="attr">');
                                            echo $attr["attr"];
                                            echo htmlentities('</div>');
                                            echo htmlentities('<div class="value">');
                                              echo $attr["value"];
                                            echo htmlentities('</div>');
                                          }
                                        echo htmlentities('</div>');
                                      }
                                        if (!empty($media->code)) {
                                            echo htmlentities('<div class="bottom-gallery-footer">' . $media->code . '</div>');
                                        }
                                    @endphp"
                                    data-remote="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/'. $media->slug) !!}"
                                  >
                                  </a>
                                  @endif
                                  @else <!-- les vidéos -->
                                  @if( $media->gid != $last_gallery_id )
                                  <?php
                                    $last_gallery_id = $media->gid;
                                  ?>
                                  <div class="media">
                                    <a
                                      class="hover-effect"
                                      data-toggle="lightbox"
                                      data-gallery="gallery-{{ $media->gslug }}"
                                      data-title="{{ $media_title . $author }}"
                                      data-footer="
                                      @php
                                        if(isset($medias_attr[$media->id])) {
                                          echo htmlentities('<div class="attrs">');
                                            foreach($medias_attr[$media->id] as $attr) {
                                              echo htmlentities('<div class="attr">');
                                              echo $attr["attr"];
                                              echo htmlentities('</div>');
                                              echo htmlentities('<div class="value">');
                                              echo $attr["value"];
                                              echo htmlentities('</div>');
                                            }
                                          echo htmlentities('</div>');
                                        }
                                      if (!empty($media->code)) {
                                        echo htmlentities('<div class="bottom-gallery-footer">' . $media->code . '</div>');
                                      }
                                      @endphp"
                                      href="#"
                                      data-remote="{{$media->slug}}"
                                    >
                                      <img
                                        class="img-fluid"
                                        src="{{ App\Helpers\Formatter::getYoutubeMiniature($media->slug) }}"
                                        alt="{{ $media->name }}"
                                        title="{{ $media->name }} - {{ strtoupper($company->name) }}">
                                      </a>

                                    <div class="caption">
                                      <h5 class="title">{{ $media->gname }}</h5>
                                    </div>

                                  </div>
                                  @else
                                  {{-- Les autres photos de la même galerie photos --}}
                                  <a
                                    style="display: none;"
                                    data-title="{{ $media_title . $author }}"
                                    data-toggle="lightbox"
                                    data-gallery="gallery-{{ $media->gslug }}"
                                    data-footer="
                                    @php
                                      if(isset($medias_attr[$media->id])) {
                                        echo htmlentities('<div class="attrs">');
                                          foreach($medias_attr[$media->id] as $attr) {
                                            echo htmlentities('<div class="attr">');
                                            echo $attr["attr"];
                                            echo htmlentities('</div>');
                                            echo htmlentities('<div class="value">');
                                              echo $attr["value"];
                                            echo htmlentities('</div>');
                                          }
                                        echo htmlentities('</div>');
                                      }
                                    if (!empty($media->code)) {
                                        echo htmlentities('<div class="bottom-gallery-footer">' . $media->code . '</div>');
                                    }
                                    @endphp"
                                    data-remote="{{$media->slug}}"
                                    href="{{$media->slug}}">
                                  </a>




                                @endif
                                @endif
                              @endif
                            @endforeach

                          </div>

                        @endif
                      </div>
                    </div>
                </div>
                @endforeach
            @endif

            <!-- Tourisme -->
            @if (isset($activities) && $activities->where('type_id', 1)->count() > 0)
            <div id="tourisme-tab" class="tab-pane">
                <table class='table table-striped'>
                    <tr>
                        <th>Activité</th>
                        <th>Catégorie</th>
                    </tr>
                    @foreach($activities->where('type_id', 1)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->category_name);
                                        })->all() as $activity)
                        <tr>
                            <td>{{$activity->name}}</td>
                            <td>{{$activity->category_name}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            @endif

                    <!-- Affaire -->
            @if (isset($activities) && $activities->where('type_id', 2)->count() > 0)
                <div id="affaire-tab" class="tab-pane">
                    <table class='table table-striped'>
                        <tr>
                            <th>Activité</th>
                            <th>Catégorie</th>
                        </tr>
                        @foreach($activities->where('type_id', 2)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->category_name);
                                        })->all() as $activity)
                            <tr>
                                <td>{{$activity->name}}</td>
                                <td>{{$activity->category_name}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif



                    <!-- Local -->
            @if (isset($activities) && $activities->where('type_id', 3)->count() > 0)
                <div id="local-tab" class="tab-pane">
                    <table class='table table-striped'>
                        <tr>
                            <th>Activité</th>
                            <th>Catégorie</th>
                        </tr>
                        @foreach($activities->where('type_id', 3)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->category_name);
                                        })->all() as $activity)
                            <tr>
                                <td>{{$activity->name}}</td>
                                <td>{{$activity->category_name}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif


                    <!-- Prime Time -->
                @if (isset($activities) && $activities->where('type_id', 4)->count() > 0)
                    <div id="primetime-tab" class="tab-pane">
                        <table class='table table-striped'>
                            <tr>
                                <th>Activité</th>
                                <th>Catégorie</th>
                            </tr>
                            @foreach($activities->where('type_id', 4)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->category_name);
                                        })->all() as $activity)
                                <tr>
                                    <td>{{$activity->name}}</td>
                                    <td>{{$activity->category_name}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
                        <!-- Videos -->
                    @if (isset($activities) && $activities->where('type_id', 5)->count() > 0)
                        <div id="videos-tab" class="tab-pane">
                            <table class='table table-striped'>
                                <tr>
                                    <th>Activité</th>
                                    <th>Catégorie</th>
                                </tr>
                                @foreach($activities->where('type_id', 5)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->category_name);
                                        })->all() as $activity)
                                    <tr>
                                        <td>{{$activity->name}}</td>
                                        <td>{{$activity->category_name}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                            <!-- Photos -->
                        @if (isset($activities) && $activities->where('type_id', 6)->count() > 0)
                            <div id="photos-tab" class="tab-pane">
                                <table class='table table-striped'>
                                    <tr>
                                        <th>Activité</th>
                                        <th>Catégorie</th>
                                    </tr>
                                    @foreach($activities->where('type_id', 6)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->category_name);
                                        })->all() as $activity)
                                        <tr>
                                            <td>{{$activity->name}}</td>
                                            <td>{{$activity->category_name}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif
                                <!-- Certificats Cadeaux Québec -->
                            @if (isset($activities) && $activities->where('type_id', 7)->count() > 0)
                                <div id="forfaits-tab" class="tab-pane">
                                    <table class='table table-striped'>
                                        <tr>
                                            <th>Activité</th>
                                            <th>Catégorie</th>
                                        </tr>
                                        @foreach($activities->where('type_id', 7)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->category_name);
                                        })->all() as $activity)
                                            <tr>
                                                <td>{{$activity->name}}</td>
                                                <td>{{$activity->category_name}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endif
                                    <!-- Certificats Cadeaux Québec -->
                                @if (isset($activities) && $activities->where('type_id', 8)->count() > 0)
                                    <div id="produits-tab" class="tab-pane">
                                        <table class='table table-striped'>
                                            <tr>
                                                <th>Activité</th>
                                                <th>Catégorie</th>
                                            </tr>
                                            @foreach($activities->where('type_id', 8)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->category_name);
                                        })->all() as $activity)
                                                <tr>
                                                    <td>{{$activity->name}}</td>
                                                    <td>{{$activity->category_name}}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @endif
                                        <!-- Plus -->
                                    @if (isset($activities) && $activities->where('type_id', 9)->count() > 0)
                                        <div id="plus-tab" class="tab-pane">
                                            <table class='table table-striped'>
                                                <tr>
                                                    <th>Activité</th>
                                                    <th>Catégorie</th>
                                                </tr>
                                                @foreach($activities->where('type_id', 9)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->category_name);
                                        })->all() as $activity)
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
      /*height: 380px !important;*/
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
