<div class="metanav">
    <div class="container">
        <ul class="quick-menu">
            <!--
            <li class="ribbon">
                @if( Session::get ('locale') == 'fr' )
                    <a href="javascript:void(0)" id="langTitle">Français</a>
                @else
                    <a href="javascript:void(0)" id="langTitle">English</a>
                @endif

                <ul class="menu mini">
                    @if( Session::get ('locale') == 'fr' )
                        <li id="langElement"><a href="/en">&gt; English</a></li>
                    @else
                        <li id="langElement"><a href="/fr">&gt; Français</a></li>
                    @endif
                </ul>
            </li>-->

                <!--
            @if (Auth::guest())
                <li><a href="#travelo-login" id='login-button'
                       class="soap-popupbox">{{ trans('front.loginButton') }}</a></li>
                <li>{{ link_to_route('account.register', trans('front.registerButton') )}}</li>
            @else
                <li class='ribbon currency menu-color-skin'><a href='#'>{{Auth::user()->name}}</a>
                    <ul class="menu mini">
                        @include('layouts.common.profil')
                    </ul>
                </li>
                <li>{{ link_to_route('admin', "Administration")}}</li>
                <li>{{ link_to_route('auth.logout', trans('front.logoutButton'))}}</li>
            @endif
                -->
        </ul>
        <ul class="quick-menu">
            <!--<li class="ribbon">
                @if( Session::get ('locale') == 'fr' )
                    <a href="javascript:void(0)" id="langTitle">Français</a>
                @else
                    <a href="javascript:void(0)" id="langTitle">English</a>
                @endif

                <ul class="menu mini">
                    @if( Session::get ('locale') == 'fr' )
                        <li id="langElement"><a href="/en">&gt; English</a></li>
                    @else
                        <li id="langElement"><a href="/fr">&gt; Français</a></li>
                    @endif
                </ul>
            </li>

            @if (Auth::guest())
                <li><a href="#travelo-login" id='login-button'
                       class="soap-popupbox">{{ trans('front.loginButton') }}</a></li>
                <li>{{ link_to_route('account.register', trans('front.registerButton') )}}</li>
            @else
                <li class='ribbon currency menu-color-skin'><a href='#'>{{Auth::user()->name}}</a>
                    <ul class="menu mini">
                        @include('layouts.common.profil')
                    </ul>
                </li>
                <li>{{ link_to_route('admin', "Administration")}}</li>
                <li>{{ link_to_route('auth.logout', trans('front.logoutButton'))}}</li>
            @endif
                    -->
        </ul>
        @if (isset($config_content))
        <ul class="quick-menu social-menu">
            <li>
                @if ($config_content->phone)
                    <a href="tel:{{ preg_replace('/[^0-9.]+/', '', $config_content->phone) }}" class="contact-link" target="_blank">{{ $config_content->phone }}</a>
                @endif
                @if ($config_content->email)
                    <a href="mailto:{{ $config_content->email }}" class="contact-link" target="_blank">{{ $config_content->email }}</a>
                @endif
            </li>

            @if ($config_content->facebook_link)
                <li><a href="{{ $config_content->facebook_link }}" target="_blank" class="facebook-btn"><i class="fa fa-facebook"></i></a></li>
            @endif
            @if ($config_content->twitter_link)
                <li><a href="{{ $config_content->twitter_link }}" target="_blank" class="twitter-btn"><i class="fa fa-twitter"></i></a></li>
            @endif
            @if ($config_content->youtube_link)
                <li><a href="{{ $config_content->youtube_link }}" target="_blank" class="youtube-btn"><i class="fa fa-youtube-play"></i></a></li>
            @endif
            @if ($config_content->pinterest_link)
                <li><a href="{{ $config_content->pinterest_link }}" target="_blank" class="pinterest-btn"><i class="fa fa-pinterest-p"></i></a></li>
            @endif
            @if ($config_content->instagram_link)
                <li><a href="{{ $config_content->instagram_link }}" target="_blank" class="instagram-btn"><i class="fa fa-instagram"></i></a></li>
            @endif

            <!--<li>
                <a href="#" class="linkedin-btn"><i class="fa fa-linkedin"></i></a>
            </li>-->
        </ul>
        @endif
    </div>
</div>


<div class="topnav">
    <div class="container">

        <!--<a id="goexploria-logo" href="/{{ trans('front.locale_url') }}"><img src="{!! URL::asset('images/logo-go-exploria.png') !!}" /></a>-->


        <div class="site-logo-block">
            <a class="navbar-brand site-logo" href="/{{ trans('front.locale_url') }}">
                <img src="{!! URL::asset('images/logo-go-exploria-qc-3.png') !!}" alt="GoExploria" width="" height="50">
                <div class="subtitle tracking-in-expand">Affaires</div>
            </a>
            <div class="mobile-clearboth"></div>
        </div><!--~./ site-logo-block ~-->

        <div class="nav-wrapper">
            <ul class="nav navbar-nav navbar-left">
                <li class="dropdown-full">
                    <a id="a_tourisme" class="dropdown-toggle effect-underline" href="#"><span class="rubrique-title">GO Explorez</span></a>
                </li>
                <li class="dropdown-full">
                    <a id="a_business" class="dropdown-toggle effect-underline" href="#"><span class="rubrique-title">GO Business</span></a>
                </li>
                <li class="dropdown-full">
                    <a id="a_local" class="dropdown-toggle effect-underline" href="#"><span class="rubrique-title">GO Local</span></a>
                </li>
                <li class="dropdown-full">
                    <a id="a_prime" class="dropdown-toggle effect-underline" href="#"><span class="rubrique-title">GO Prime Time</span></a>
                </li>
                <li class="dropdown-full">
                    <a id="a_videos" class="dropdown-toggle effect-underline" href="#"><span class="rubrique-title">GO Web TV</span></a>
                </li>
                <li class="dropdown-full">
                    <a id="a_photos" class="dropdown-toggle effect-underline" href="#"><span class="rubrique-title">GO Photos</span></a>
                </li>
                <li class="dropdown-full">
                    <a id="a_forfaits" class="dropdown-toggle effect-underline" href="#"><span class="rubrique-title">GO Certificats Cadeaux Québec</span></a>
                </li>
                <li class="dropdown-full">
                    <a id="a_produits" class="dropdown-toggle effect-underline" href="#"><span class="rubrique-title">GO Marketplace</span></a>
                </li>
                <li class="dropdown-full">
                    <a id="a_plus" class="dropdown-toggle effect-underline" href="#"><span class="rubrique-title">GO Book Direct</span></a>
                </li>
                <!--<li class="dropdown-full">
                    <a id="a_photo" class="effect-underline" href="#"><span class="rubrique-title">GO Photos</span></a>
                </li>-->

                <!--
                <li class="dropdown-full">
                    <a id="a_video" class="" href="#"><span class="rubrique-title">GO Vidéo</span></a>
                </li>
                -->
            </ul>


            <div class="relance-right-buttons">
                <a id="a_relance" class="dropdown-toggle" href="https://www.goexploria.com/company/68620/go-exploria-plans-de-relance">
                    <span class="lys-img"><img src="{!! URL::asset('images/lysquebecfonce.png') !!}" /></span>
                    <span class="rubrique-title">Plans de relance</span>
                </a>
                <a id="a_web" class="dropdown-toggle" href="https://www.goexploria.com/company/68619/go-exploria-services-web">
                    <span class="rubrique-title">Services web</span>
                    <span class="lys-img"><img src="{!! URL::asset('images/earth.png') !!}" /></span>
                </a>
            </div>
            <!--<a title="{{ trans('front.search_placeholder') }}" id="a_search" class="" href="#"><span
                        class="rubrique-title"><i class="fa fa-search"></i></span></a>-->

        </div>
    </div>
</div>
<div class="header-search">
  <span class="search-engine">
      <select id="search-engine" minChar='3' redirect source='{{route('search', [':data'])}}' placeholder="{{ trans('front.search_placeholder') }}">
          <option value="" selected="selected"></option>
      </select>
  </span>
</div>

<!--<div id="search-bar" style="display: none;" class="menu-single-bar">
  <span class="search-engine">
      <select id="search-engine" minChar='3' redirect source='{{route('search', [':data'])}}' placeholder="{{ trans('front.search_placeholder') }}">
          <option value="" selected="selected"></option>
      </select>
      <div class="content">
        <p>Recherchez une destination, une entreprise ou même une activité, partout dans le monde!</p>
      </div>
      <a class="search-bar-close" href="#">Fermer</a>
  </span>
</div>-->

<div id="search-company-bar" style="display: none;" class="menu-single-bar">
  <span class="search-company">
      <div class="content">
          <!-- <span class="title">Explorer par catégories</span> -->
          <ul class="bar">
              @foreach( $tourismeCategories as $category )
                  <li class="btn-success"><a href="#" class="list_item">{{ $category->name }}</a>

                      <ul class="sub" style="display: none;">
                          @foreach( $tourismeActivities[$category->slug] as $activities )
                              <li><a href="{{ route('front.activity.search', [$activities['id'], $activities['slug']]) }}" class="btn-success self-select" data-id="{{ $activities['id'] }}"><i class="fa fasmaller fa-chevron-right"></i> {{ $activities['name'] }}</a></li>
                          @endforeach
                      </ul>

                  </li>
              @endforeach
          </ul>

      </div>
      <a class="search-company-bar-close" href="#"><i class="btn fa fa-close"></i></a>
  </span>
</div>

<div id="search-business-bar" style="display: none;" class="menu-single-bar">
  <span class="search-business">
      <div class="content">
          <!-- <span class="title">Explorer par catégories</span> -->
          <ul class="bar">
              @foreach( $businessCategories as $category )
                  <li class="btn-success"><a href="#" class="list_item">{{ $category->name }}</a>

                      <ul class="sub" style="display: none;">
                          @foreach( $businessActivities[$category->slug] as $activities )
                              <li><a href="{{ route('front.activity.search', [$activities['id'], $activities['slug']]) }}" class="btn-success self-select" data-id="{{ $activities['id'] }}"><i class="fa fasmaller fa-chevron-right"></i> {{ $activities['name'] }}</a></li>
                          @endforeach
                      </ul>

                  </li>
              @endforeach
          </ul>

      </div>
      <a class="search-business-bar-close" href="#"><i class="btn fa fa-close"></i></a>
  </span>
</div>

<div id="search-local-bar" style="display: none;" class="menu-single-bar">
  <span class="search-local">
      <div class="content">
          <!-- <span class="title">Explorer par catégories</span> -->
          <ul class="bar">
              @foreach( $localCategories as $category )
                  <li class="btn-success"><a href="#" class="list_item">{{ $category->name }}</a>

                      <ul class="sub" style="display: none;">
                          @foreach( $localActivities[$category->slug] as $activities )
                              <li><a href="{{ route('front.activity.search', [$activities['id'], $activities['slug']]) }}" class="btn-success self-select" data-id="{{ $activities['id'] }}"><i class="fa fasmaller fa-chevron-right"></i> {{ $activities['name'] }}</a></li>
                          @endforeach
                      </ul>

                  </li>
              @endforeach
          </ul>

      </div>
      <a class="search-local-bar-close" href="#"><i class="btn fa fa-close"></i></a>
  </span>
</div>

<div id="search-prime-bar" style="display: none;" class="menu-single-bar">
  <span class="search-prime">
      <div class="content">
          <!-- <span class="title">Explorer par catégories</span> -->
          <ul class="bar">
              @foreach( $primeCategories as $category )
                  <li class="btn-success"><a href="#" class="list_item">{{ $category->name }}</a>

                      <ul class="sub" style="display: none;">
                          @foreach( $primeActivities[$category->slug] as $activities )
                              <li><a href="{{ route('front.activity.search', [$activities['id'], $activities['slug']]) }}" class="btn-success self-select" data-id="{{ $activities['id'] }}"><i class="fa fasmaller fa-chevron-right"></i> {{ $activities['name'] }}</a></li>
                          @endforeach
                      </ul>

                  </li>
              @endforeach
          </ul>

      </div>
      <a class="search-prime-bar-close" href="#"><i class="btn fa fa-close"></i></a>
  </span>
</div>

<div id="search-videos-bar" style="display: none;" class="menu-single-bar">
  <span class="search-videos">
      <div class="content">
          <!-- <span class="title">Explorer par catégories</span> -->
          <ul class="bar">
              @foreach( $videosCategories as $category )
                  <li class="btn-success"><a href="#" class="list_item">{{ $category->name }}</a>

                      <ul class="sub" style="display: none;">
                          @foreach( $videosActivities[$category->slug] as $activities )
                              <li><a href="{{ route('front.activity.search', [$activities['id'], $activities['slug']]) }}" class="btn-success self-select" data-id="{{ $activities['id'] }}"><i class="fa fasmaller fa-chevron-right"></i> {{ $activities['name'] }}</a></li>
                          @endforeach
                      </ul>

                  </li>
              @endforeach
          </ul>

      </div>
      <a class="search-videos-bar-close" href="#"><i class="btn fa fa-close"></i></a>
  </span>
</div>

<div id="search-photos-bar" style="display: none;" class="menu-single-bar">
  <span class="search-photos">
      <div class="content">
          <!-- <span class="title">Explorer par catégories</span> -->
          <ul class="bar">
              @foreach( $photosCategories as $category )
                  <li class="btn-success"><a href="#" class="list_item">{{ $category->name }}</a>

                      <ul class="sub" style="display: none;">
                          @foreach( $photosActivities[$category->slug] as $activities )
                              <li><a href="{{ route('front.activity.search', [$activities['id'], $activities['slug']]) }}" class="btn-success self-select" data-id="{{ $activities['id'] }}"><i class="fa fasmaller fa-chevron-right"></i> {{ $activities['name'] }}</a></li>
                          @endforeach
                      </ul>

                  </li>
              @endforeach
          </ul>

      </div>
      <a class="search-photos-bar-close" href="#"><i class="btn fa fa-close"></i></a>
  </span>
</div>

<div id="search-forfaits-bar" style="display: none;" class="menu-single-bar">
  <span class="search-forfaits">
      <div class="content">
          <!-- <span class="title">Explorer par catégories</span> -->
          <ul class="bar">
              @foreach( $forfaitsCategories as $category )
                  <li class="btn-success"><a href="#" class="list_item">{{ $category->name }}</a>

                      <ul class="sub" style="display: none;">
                          @foreach( $forfaitsActivities[$category->slug] as $activities )
                              <li><a href="{{ route('front.activity.search', [$activities['id'], $activities['slug']]) }}" class="btn-success self-select" data-id="{{ $activities['id'] }}"><i class="fa fasmaller fa-chevron-right"></i> {{ $activities['name'] }}</a></li>
                          @endforeach
                      </ul>

                  </li>
              @endforeach
          </ul>

      </div>
      <a class="search-forfaits-bar-close" href="#"><i class="btn fa fa-close"></i></a>
  </span>
</div>

<div id="search-produits-bar" style="display: none;" class="menu-single-bar">
  <span class="search-produits">
      <div class="content">
          <!-- <span class="title">Explorer par catégories</span> -->
          <ul class="bar">
              @foreach( $produitsCategories as $category )
                  <li class="btn-success"><a href="#" class="list_item">{{ $category->name }}</a>

                      <ul class="sub" style="display: none;">
                          @foreach( $produitsActivities[$category->slug] as $activities )
                              <li><a href="{{ route('front.activity.search', [$activities['id'], $activities['slug']]) }}" class="btn-success self-select" data-id="{{ $activities['id'] }}"><i class="fa fasmaller fa-chevron-right"></i> {{ $activities['name'] }}</a></li>
                          @endforeach
                      </ul>

                  </li>
              @endforeach
          </ul>

      </div>
      <a class="search-produits-bar-close" href="#"><i class="btn fa fa-close"></i></a>
  </span>
</div>

<div id="search-plus-bar" style="display: none;" class="menu-single-bar">
  <span class="search-plus">
      <div class="content">
          <!-- <span class="title">Explorer par catégories</span> -->
          <ul class="bar">
              @foreach( $plusCategories as $category )
                  <li class="btn-success"><a href="#" class="list_item">{{ $category->name }}</a>

                      <ul class="sub" style="display: none;">
                          @foreach( $plusActivities[$category->slug] as $activities )
                              <li><a href="{{ route('front.activity.search', [$activities['id'], $activities['slug']]) }}" class="btn-success self-select" data-id="{{ $activities['id'] }}"><i class="fa fasmaller fa-chevron-right"></i> {{ $activities['name'] }}</a></li>
                          @endforeach
                      </ul>

                  </li>
              @endforeach
          </ul>

      </div>
      <a class="search-plus-bar-close" href="#"><i class="btn fa fa-close"></i></a>
  </span>
</div>

<ul role="menu" class="subnav">
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/canada.gif') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada') !!}"><span>{{ trans('front.canada') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/quebec-province.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec') !!}"><span>{{ trans('front.quebec-province') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/abitibi-temiscamingue.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/abitibi-temiscamingue') !!}"><span>{{ trans('front.abitibi-temiscamingue') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/bas-saint-laurent.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/bas-saint-laurent') !!}"><span>{{ trans('front.bas-saint-laurent') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/region-cantons-de-l-est.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/region-cantons-de-l-est') !!}"><span>{{ trans('front.region-cantons-de-l-est') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/centre-du-quebec.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/centre-du-quebec') !!}"><span>{{ trans('front.centre-du-quebec') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/charlevoix.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/charlevoix') !!}"><span>{{ trans('front.charlevoix') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/chaudiere-appalaches.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/chaudiere-appalaches') !!}"><span>{{ trans('front.chaudiere-appalaches') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/cote-nord.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/cote-nord') !!}"><span>{{ trans('front.cote-nord') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/eeyou-istchee-baie-james.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/eeyou-istchee-baie-james') !!}"><span>{{ trans('front.eeyou-istchee-baie-james') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/gaspesie.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/gaspesie') !!}"><span>{{ trans('front.gaspesie') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/iles-de-la-madeleine.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/iles-de-la-madeleine') !!}"><span>{{ trans('front.iles-de-la-madeleine') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/tourisme-lac-saint-jean.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/tourisme-lac-saint-jean') !!}"><span>{{ trans('front.tourisme-lac-saint-jean') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/lanaudiere.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/lanaudiere') !!}"><span>{{ trans('front.lanaudiere') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/laurentides.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/laurentides') !!}"><span>{{ trans('front.laurentides') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/laval.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/laval') !!}"><span>{{ trans('front.laval') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/region-de-la-mauricie.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/region-de-la-mauricie') !!}"><span>{{ trans('front.region-de-la-mauricie') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/monteregie.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/monteregie') !!}"><span>{{ trans('front.monteregie') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/montreal.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/montreal') !!}"><span>{{ trans('front.montreal') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/nunavik-grand-nord-du-quebec.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/nunavik-grand-nord-du-quebec') !!}"><span>{{ trans('front.nunavik-grand-nord-du-quebec') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/tourisme-outaouais.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/tourisme-outaouais') !!}"><span>{{ trans('front.tourisme-outaouais') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/quebec.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/quebec') !!}"><span>{{ trans('front.quebec') }}</span></a>
    </li>
    <li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/saguenay.jpg') !!});">
        <a href="{!! url( trans('front.locale_url') . 'location/na/canada/quebec/saguenay') !!}"><span>{{ trans('front.saguenay') }}</span></a>
    </li>
</ul>
<!--
<ul role="menu" class="subnav">
	<li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/africa.jpg') !!});">
		<a href="{!! url( trans('front.locale_url') . 'location/af') !!}"><span>{{ trans('front.afrique') }}</span></a>
	</li>
	<li id="li-amerique" class="nav-item" style="background-image: url({!! URL::asset('images/submenu/america.jpg') !!});"> 
		<a href="#"><span>{{ trans('front.amerique') }}</span></a>
		<ul class="nav-subitem">
			<li><a href="{!! url( trans('front.locale_url') . 'location/na') !!}"><span>{{ trans('front.amerdun') }}</span></a></li>
			<li><a href="{!! url( trans('front.locale_url') . 'location/ac') !!}"><span>{{ trans('front.amerc') }}</span></a></li>
			<li><a href="{!! url( trans('front.locale_url') . 'location/cs') !!}"><span>{{ trans('front.amercaraibes') }}</span></a></li>			
			<li><a href="{!! url( trans('front.locale_url') . 'location/sa') !!}"><span>{{ trans('front.amerdus') }}</span></a></li>
		</ul>
	</li> 
	<li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/asia.jpg') !!});"> 
		<a href="{!! url( trans('front.locale_url') . 'location/as') !!}"><span>{{ trans('front.asie') }}</span></a>
	</li> 
	<li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/europe.jpg') !!});"> 
		<a href="{!! url( trans('front.locale_url') . 'location/eu') !!}"><span>{{ trans('front.europe') }}</span></a>	
	</li> 
	<li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/oceanie.jpg') !!});"> 
		<a href="{!! url( trans('front.locale_url') . 'location/oc') !!}"><span>{{ trans('front.oceanie') }}</span></a>	
	</li> 
	<li class="nav-item" style="background-image: url({!! URL::asset('images/submenu/orient.jpg') !!});"> 
		<a href="{!! url( trans('front.locale_url') . 'location/or') !!}"><span>{{ trans('front.moyen-orient') }}</span></a>	
	</li>  
</ul>
-->

<div class="clearfix"></div>
