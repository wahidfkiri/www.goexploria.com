@if (isset( $company->socialNetworks ) && $company->socialNetworks->hasNetworks() )
    <div class="topbar">
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
            <li><a href="{{ $conn_url }}">Connexion</a></li>
            <li><a href="{{ $reg_url }}">Inscription</a></li>
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
    <div class="wrapper-right">
        @foreach ($company->socialNetworks->getNetworks() as $network)
            <a href="{{$company->socialNetworks[$network[0]]}}" target="_blank">
                <i class="fa {{$network[1]}} logo-{{$network[0]}}"
                   aria-hidden="true"></i>
            </a>
        @endforeach
    </div>
@endif

@if( isset($company) )
    @if( isset($company_headImage) && !empty($company_headImage) )
        <div class="header-bg">
            @else
                <div class="topnav ">
                    @endif
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                @if( isset($company_logo) && !empty($company_logo) )
                                    <div id="logo_company_site">
                                        <a href="/">
                                            <img alt="Logo {{ $company->name }}"
                                                 src="{{ URL::asset('uploads/companies/'.$company->id.'/'. $company_logo) }}">
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div id="headImage">
                            <!--     <img src="{{--URL::asset('uploads/companies/'.$company->id.'/'. $company_headImage)--}}">-->
                            </div>
                            <div class="col-sm-8">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="wrap-info-cie">
                                    <span class="info_company"><a href="#">{{$coordinate->tel}}</a></span> &nbsp;
                                    <span class="info_company"><a href="mailto:">{{$coordinate->mail}}</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!--  menu like amazon -->
                            <a href="#menu" id="toggle"><span></span></a>
                            <div id="menu">
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
                                                                <li>
                                                                    <a class=" @if( $page->slug == $sp->slug ) active @endif"
                                                                       href="{{ url($sp->slug) }}" data-hover="">{{ $sp->name }}
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
                            <!--  fin- menu like amazon -->
                        </div>
                    </div>
                </div>
    @else
        {{ dd('Error with company') }}
    @endif
