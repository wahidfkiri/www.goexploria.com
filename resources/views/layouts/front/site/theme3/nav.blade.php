@if( isset($company) )
    @if( isset($company_headImage) && !empty($company_headImage) )
        <div class="header-bg"
             style="background-image:url({{ URL::asset('uploads/companies/'.$company->id.'/'. $company_headImage) }})">
            @else
                <div class="topnav ">
                    @endif
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                @if( isset($company_logo) && !empty($company_logo) )
                                    <div id="logo_company_site">
                                        <a href="/">
                                            <img alt="Logo {{ $company->name }}" src="{{ URL::asset('uploads/companies/'.$company->id.'/'. $company_logo) }}">
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div id="headImage">
                            <!--     <img src="{{--URL::asset('uploads/companies/'.$company->id.'/'. $company_headImage)--}}">-->
                            </div>
                            <div class="col-sm-8">

                                    <div class="topbar">
                                        <div class="right">
                                            @yield('socialNetworks')
                                        </div>
                                        <!--bouton de langue  -->
                                      <!--  <div class="btn-group">
                                            <button class="btn btn-language btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Langues
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"><img src="" alt="">Français</a>
                                                <a class="dropdown-item" href="#">Englais</a>
                                                <a class="dropdown-item" href="#">Espagnol</a>
                                            </div> -->
                                        </div>
                                    </div>
                            </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="wrap-info-cie">
                                    <span class="info_company"><a href="#">{{$coordinate->tel}}</a></span> &nbsp;
                                    <span class="info_company"><a href="mailto:">{{$coordinate->mail}}</a></span>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <!-- menu actuel-->
                                <a href="#menu" id="toggle"><span></span></a>
                                <ul id="menu" class="nav navbar-nav navbar-right">
                                    <li class="btn-primary @if( $page->slug == 'accueil' ) active @endif">
                                        <a href="{{ url('/') }}">Accueil</a>
                                    </li>
                                    @if( isset( $pages ) )
                                        @foreach( $pages as $key => $p )
                                            @php
                                                $children = $p->children;
                                            @endphp
                                            @if( $children->count() > 0 )
                                                <li class="dropdown btn-primary @if( $page->slug == $p->slug ) active @endif" role="presentation">
                                                    <a href=" @if( $p->content != null || $p->content != '' ) {{ url($p->slug) }}
                                                    @else #
                                                    @endif"class="dropdown-toggle" data-toggle="dropdown" role="button"> {{ $p->name }}
                                                        <span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        @foreach($children as $sp)
                                                            <li class="btn-primary @if( $page->slug == $sp->slug ) active @endif">
                                                                <a href="{{ url($sp->slug) }}">{{ $sp->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                            @else
                                                <li class="btn-primary @if( $page->slug == $p->slug ) active @endif">
                                                    <a href="{{ url($p->slug) }}">{{ $p->name }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                    <li class="btn-primary @if( $page->slug == 'contact' ) active @endif">
                                        <a href="{{ url('contact') }}">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
    @else
        {{ dd('Error with company') }}
    @endif
