@if (isset( $company->socialNetworks ) && $company->socialNetworks->hasNetworks() )
<div class="infos-header" style="background-color:#57C0D1;">
        <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <ul class="infos">
                            <li><a href="/">{{ $company->name }}</a> </li>
                            <li><a href="tel:{{$coordinate->tel}}">{{$coordinate->tel}}</a></li>
                            <li><a href="mailto:{{$coordinate->mail}}">{{$coordinate->mail}}</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="more-actions">
                            <div class="row">
                                    <div class="col-sm col-md">
                                        <div id="login-btn">
                                                @php
                                                $newdomain = parse_url($_ENV['APP_URL'])['host'];
                                                $route = route('auth.login');
                                                $olddomain = parse_url($route)['host'];
                                                $conn_url = str_replace($olddomain, $newdomain, $route);
                                                $route = route('account.register');
                                                $reg_url = str_replace($olddomain, $newdomain, $route);
                                              @endphp
                                               <a class="hvr-outline-out" href="{{ $conn_url }}?id={{ $company->id }}"> <i class='fas fa-user-alt'></i></a>
                                        </div>
                                    </div>
                                    <div class="col-sm col-md">
                                        <div class="follow-us">
                                            <div id="dropdown-social-medias">
                                                <a  id="drop-btn"  data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false"> Suivez-nous</a>
            
                                                <div class="dropdown-menu social-dropdown-menu">
                                                  <ul class="list-inline">
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
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{$company->socialNetworks[$network[0]]}}" target="_blank">
                                                                        <i class="fab {{$network[1]}} logo-{{$network[0]}}"
                                                                           aria-hidden="true" style="font-size:32px;"></i>
                                                                    </a>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endif

                                                    <!--
                                                      <li> <a class="dropdown-item" href="#"><i class="fab fa-facebook-f"></i></a></li>
                                                      <li> <a class="dropdown-item" href="#"><i class="fab fa-instagram"></i></a></li>
                                                      <li> <a class="dropdown-item" href="#"><i class="fab fa-pinterest"></i></a></li>
                                                      <li> <a class="dropdown-item" href="#"><i class="fab fa-twitter"></i></a></li>
                                                      <li> <a class="dropdown-item" href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                                      <li> <a class="dropdown-item" href="#"><i class="fab fa-youtube"></i></a></li>
                                                      <li> <a class="dropdown-item" href="#"><i class="fab fa-reddit"></i></a></li>
                                                    -->
                                                  </ul>
                                         
                                                </div>
            
                                            </div>
    
                                        </div>
                    
                                    </div>
                                   
                                    <div class="col-sm col-md lang-selector">
                                        FR/EN
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
                                    <div class="col-sm col-md">
                                            <i class='fas fa-shopping-cart'></i>
                                    </div>
                                </div>
                            </div>
                           
                      
                     
                        </div>
                     
                        
                    </div>
                </div>
    </div>

@endif

@if( isset($company) )
<!-- start header -->
<header id="main-header">      
        <div class="container"> 
            <div class="top-header-1">
              <div class="row">
                  <div class="col-10 col-sm-12 col-md logo-container">
                        <div class="logo">
                            <a href="/">
                                @if( isset($company_logo) && !empty($company_logo) )
                                    <img alt="Logo {{ $company->name }}" src="{{ URL::asset('uploads/companies/'.$company->id.'/'. $company_logo) }}">
                                @else 
                                        <h1> Les petits bonheurs de Marguerite</h1>
                                @endif
                            </a>
                        </div> <!-- end logo -->
                  </div>
                  <!-- menu -->
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#responsive-menu" aria-controls="responsive-menu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                      </button>
                  <div class="col-sm-12 col-md-6 nav-container">
                      
                            <nav class="navbar navbar-expand-lg navbar-light">
                                   
                                <div class="collapse navbar-collapse" id="responsive-menu">
                                  <ul class="navbar-nav mr-auto">

                                    <li class="nav-item @if( $page->slug == 'accueil' ) active @endif">
                                            <a class="nav-link" href="{{ url('/') }}">Accueil</a>
                                        </li>

                                    @if( isset( $pages ) )
                                      @foreach( $pages as $key => $p )
                                          @php
                                              $children = $p->children;
                                          @endphp
                                          @if( $children->count() > 0 )
                                              <li class="nav-item @if( $page->slug == $p->slug ) active @endif">
                                                  <a class="nav-link" href=" @if( $p->content != null || $p->content != '' ) {{ url($p->slug) }}
                                                  @else javascript:void(0);
                                                                  @endif" data-hover="{{ $p->name }}"> {{ $p->name }}</a>
                                                  <div>
                                                      <ul>
                                                          @foreach($children as $sp)
                                                              <li class="nav-item" @if( $children->count() == 1 ) style="width:auto;" @endif>
          
                                                                  <a class="nav-link @if( $page->slug == $sp->slug ) active @endif"
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
                                              <li class="nav-item @if( $page->slug == $p->slug ) active @endif">
                                                  <a class="nav-link" href="{{ url($p->slug) }}" data-hover="">{{ $p->name }}
                                                      @if ($p->logo_url)
                                                          <img class="img-responsive" src="{{ '/uploads/pagesLogo/' . $p->logo_url }}" alt="">
                                                      @endif
                                                  </a>
                                              </li>
                                          @endif
                                      @endforeach
                                  @endif
                                  <li class="nav-item @if( $page->slug == 'contact' ) active @endif">
                                      <a class="nav-link" href="{{ url('contact') }}">Contact</a>
                                  </li>

                                  
                                  </ul>
                                </div>
                            </nav>
                

                  </div>
                  <!-- end menu -->
              </div>
            </div>
       </div>
</header>
<!-- end header -->

<!-- banner --> 
@if( isset($company_headImage) && !empty($company_headImage) )
    <div class="banner-section">
        <img src="{{ URL::asset('uploads/companies/'.$company->id.'/'. $company_headImage) }}" />
    </div>
@endif
<!-- end banner --> 
              
@else
    {{ dd('Error with company') }}
@endif
