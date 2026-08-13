<style type="text/css">
    .social-btn{color:#fff;cursor:pointer;position:relative;}
    .social-btn:hover .social-dropdown{display:block;}
    .social-dropdown{display:none;position:absolute;top:20px;left:0;background-color:#57C0D1;text-align:center;width:100%;}
    .social-dropdown li{margin-right:0px!important;padding:12px;}
</style>
@if (isset( $company->socialNetworks ) && $company->socialNetworks->hasNetworks() )
    <div class="topbar" style="background-color:#57C0D1;">
        <div class="wrap-info-cie">
            <span class="info_company"><a href="/">{{ $company->name }}</a></span> &nbsp;
            <span class="info_company"><a href="tel:{{$coordinate->tel}}">{{$coordinate->tel}}</a></span> &nbsp;
            <span class="info_company"><a href="mailto:{{$coordinate->mail}}">{{$coordinate->mail}}</a></span>
        </div>
        <!-- bouton de langue -->
        <ul class="login_menu">
          @php
            $newdomain = parse_url($_ENV['APP_URL'])['host'];
            $route = route('auth.login');
            $olddomain = parse_url($route)['host'];
            $conn_url = str_replace($olddomain, $newdomain, $route);
            $route = route('account.register');
            $reg_url = str_replace($olddomain, $newdomain, $route);
          @endphp
            <li><a class="hvr-outline-out" href="{{ $conn_url }}?id={{ $company->id }}">Connexion</a></li>
            <!--<li><a class="hvr-outline-out" href="{{ $reg_url }}">Inscription</a></li>-->
            @if($company->rs_position == 0)
                @foreach ($company->socialNetworks->getNetworks() as $network)
                    <li><a href="{{$company->socialNetworks[$network[0]]}}" target="_blank">
                        <i class="fa {{$network[1]}} logo-{{$network[0]}}"
                           aria-hidden="true" style="font-size:21px;"></i>
                    </a></li>
                @endforeach
            @elseif($company->rs_position == 1)
                <li class="social-btn">
                    Suivez-nous
                    <ul class="social-dropdown">
                        @foreach ($company->socialNetworks->getNetworks() as $network)
                            <li><a href="{{$company->socialNetworks[$network[0]]}}" target="_blank">
                                <i class="fa {{$network[1]}} logo-{{$network[0]}}"
                                   aria-hidden="true" style="font-size:32px;"></i>
                            </a></li>
                        @endforeach
                    </ul>
                </li>
            @endif
        </ul>
        <!--div class="btn-group">
            <button class="btn btn-language btn-sm dropdown-toggle" type="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Langues
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#"><img src="" alt="">Français</a>
                <a class="dropdown-item" href="#">Englais</a>
                <a class="dropdown-item" href="#">Espagnol</a>
            </div>
        </div-->
    </div>
@endif

@if( isset($company) )
    @if( isset($company_headImage) && !empty($company_headImage) )

        <div class="header-img">
            <a href="/"><img src="{{ URL::asset('uploads/companies/'.$company->id.'/'. $company_headImage) }}" class="img-responsive" /></a>
        </div>

        <!--<div class="header-bg" style="background-image:linear-gradient(rgba(0,0,0,0.65) ,rgba(0,0,0,0.32)), url({{ URL::asset('uploads/companies/'.$company->id.'/'. $company_headImage) }})">

            @endif

                <div class="topnav ">
                    <div class="container">
                        <div class="row">
                                @if( isset($company_logo) && !empty($company_logo) )
                                    <div id="logo_company_site">
                                        <a href="/">
                                            <img alt="Logo {{ $company->name }}"
                                                 src="{{ URL::asset('uploads/companies/'.$company->id.'/'. $company_logo) }}">
                                        </a>
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>

        </div>-->
        <!--  menu like amazon -->

        <style type="text/css">
            .amazonmenu > ul{background-color:{{ $company->menu_bg }};}
            .amazonmenu > ul li a{color:{{ $company->menu_color }};background-color:{{ $company->menu_bg }};}
            .amazonmenu > ul li a::before{color:{{ $company->menu_color }};}
            .amazonmenu ul li > div, .amazonmenu ul li > ul{color:{{ $company->menu_color }};background-color:{{ $company->menu_bg }};}
        </style>

        <a href="#menu" id="toggle"><span></span></a>
        <div id="menu">
            <div style="max-width:1920px;margin:auto;">
                <nav id="demo" class="amazonmenu navbar">
                    <ul class="nav-menu">
                        <li class="@if( $page->slug == 'accueil' ) active @endif"><a
                                    href="{{ url('/') }}">Accueil</a>
                        </li>

                        @if( isset( $pages ) )
                            @foreach( $pages as $key => $p )
                                @php
                                    $children = $p->children;
                                @endphp
                                @if( $children->count() > 0 )
                                    <li class="@if( $page->slug == $p->slug ) active @endif">
                                        <a href=" @if( $p->content != null || $p->content != '' ) {{ url($p->slug) }}
                                        @else javascript:void(0);
                                                        @endif" data-hover="{{ $p->name }}"> {{ $p->name }}</a>
                                        <div>
                                            <ul>
                                                @foreach($children as $sp)
                                                    <li @if( $children->count() == 1 ) style="width:auto;" @endif>

                                                        <a class=" @if( $page->slug == $sp->slug ) active @endif"
                                                           href="@if( $sp->external_link != ''){{ $sp->external_link }}@else{{ url($sp->slug) }}@endif" data-hover=""@if( $sp->external_link != '') {{ ' target="_blank' }}@endif>{{ $sp->name }}
                                                            @if ($sp->logo_url)
                                                                <img class="img-responsive" src="{{ '/uploads/pagesLogo/' . $sp->logo_url }}" alt="">
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                @else
                                    <li class=" @if( $page->slug == $p->slug ) active @endif">
                                        <a href="{{ url($p->slug) }}" data-hover="">{{ $p->name }}
                                            @if ($p->logo_url)
                                                <img class="img-responsive" src="{{ '/uploads/pagesLogo/' . $p->logo_url }}" alt="">
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                        <li class=" @if( $page->slug == 'contact' ) active @endif">
                            <a href="{{ url('contact') }}">Contact</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!--  fin- menu like amazon -->
    @else
        {{ dd('Error with company') }}
    @endif
