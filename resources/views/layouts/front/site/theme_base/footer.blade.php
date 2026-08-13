
@if( $medias->where('gcarousel', 1)->count() > 0 )
    <div class="multiple-item-slider">

    
            <div class="container my-4">
                    <!--Carousel Wrapper-->
                <div id="multi-item-slider-content" class="carousel slide carousel-multi-item" data-ride="carousel">
            
                        <!--Controls-->
                        <div class="controls-top clearfix">
                            <a class="btn-floating left" href="#multi-item-slider-content" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
                            <a class="btn-floating right" href="#multi-item-slider-content" data-slide="next"><i class="fa fa-chevron-right"></i></a>
                        </div>
                        <!--/.Controls-->
                
                    
                        <!--Slides-->
                        <div class="carousel-inner" role="listbox">
                    
                            <!--First slide-->
                        <div class="carousel-item active">
                    
                            <div class="row">
                                @foreach( $medias->where('gcarousel', 1) as $media)
                                    <div class="col-md-3">
                                        <div class="card">
                                            @if ($media->target != '')
                                                <a target="_blank" href="{{ $media->target }}">
                                            @endif
                                            @if ($media->photo)
                                                <img  class="card-img-top" alt="{{ $media->name }}" title="{{ $media->name }} - {{ strtoupper($company->name) }}" src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}" alt="{{ $media->id }}">
                                            @endif
                                            @if ($media->target != '')
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                            
                            <!--/.First slide-->
                        </div>
                        <!--/.Slides-->
                    
                </div>
                        <!--/.Carousel Wrapper-->
                    
            </div>
            
    </div>
@endif
@if ($company->newsletter == 0)  
<div id="newsletter-section">
    <h5>Inscrivez-vous à notre infolettre dès maintenant!</h5>
    {{ Form::open(array('route' => array('front.company.newsletter.subscribe.post', $company->id), 'method' => 'POST', 'id' => 'signupForm', 'class' => 'form-horizontal form-groups-bordered', 'autocomplete' => 'off')) }}
    <div class="container">
        <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-5">
                    {{ Form::text('name', null, ['class' => 'form-control', 'min'=>3, 'placeholder' => 'Votre nom...', 'id' => 'name']) }}
                    </div>
                    <div class="col-md-5">
                        {{ Form::text('mail', null, ['class' => 'form-control', 'min'=>6, 'placeholder' => 'Votre adresse courriel...', 'id' => 'mail']) }}
                    </div>
                    <div class="col-md-2">
                        {!! Form::submit('S\'abonner', array('class'=>'btn btn-primary mb-2 send-btn')) !!} 
                    </div>
            </div>
        </div>
        </div>
    </div>
    {!! app('captcha')->render($lang = 'fr'); !!}
    {{ Form::close() }}
</div> 
@endif
{{-- @yield('slider') --}}
@if( isset($company) )
    @if( isset($company_footerImage) && !empty($company_footerImage) )
    <footer id="main-footer" style="background-image:url({{ URL::asset('uploads/companies/'.$company->id.'/'. $company_footerImage) }});color:{{ $company->footer_text_color }};text-shadow:1px 1px 2px #000;">
    @else
    <footer id="main-footer" style="background-color:#000;color:#fff;">
    @endif
    <div class="container footer-nav">
            <div class="row">
                <div class="col-md">
                    <h6 class="section-title"> Liens </h6>
                    <nav class="nav">
                        <ul>
                            <li>
                                <a href="{{ url($company_domain) }}">Accueil</a>
                            </li>
                            @if(isset($pages))
                                @foreach($pages as $key => $value)
                                    <li><a href="@if( $value->external_link != ''){{ url($value->external_link) }}@else{{ url($company_domain . $value->slug) }}@endif"@if( $value->external_link != '') {{ ' target="_blank' }}@endif>{{ $value->name }}</a></li>
                                @endforeach
                            @endif
                            <li>
                                <a href="{{ url($company_domain . 'contact', [$company->slug, 'contact']) }}">Contact</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                @if (isset( $company->socialNetworks ) && $company->socialNetworks->hasNetworks() )
                <div class="col-md">
                        <h6 class="section-title"> Suivez-nous</h6>
                            <nav class="nav social-media">
                                <ul>
    
                                @foreach ($company->socialNetworks->getNetworks() as $network)
                                <li>  <a href="{{$company->socialNetworks[$network[0]]}}" target="_blank">
                                        <i class="fab {{$network[1]}} logo-{{$network[0]}}"
                                            aria-hidden="true"></i>
                                    </a>
                                </li>
                                @endforeach
                                    <!--
                                <li> <a  href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li> <a  href="#"><i class="fab fa-instagram"></i></a></li>
                                <li> <a  href="#"><i class="fab fa-pinterest"></i></a></li>
                                <li> <a  href="#"><i class="fab fa-twitter"></i></a></li>
                                <li> <a  href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li> <a  href="#"><i class="fab fa-youtube"></i></a></li>
                                <li> <a  href="#"><i class="fab fa-reddit"></i></a></li>
                                    -->
                                </ul>
                            </nav>
                    </div>
                    @endif
    
                <div class="col-md">
                    <h6 class="section-title"> {{ $company->name }} </h6>
                        <nav class="nav">
                            <ul>
    
                                <li>   
                                    <span class="info_company tel">Téléphone: <a href="tel:{{$coordinate->tel}}">{{$coordinate->tel}}</a></span>
                                </li>
                                <li>
                                    <span class="info_company mail">Courriel: <a href="mailto:{{$coordinate->mail}}">{{$coordinate->mail}}</a></span>
                                </li>
                            </ul>
                        </nav>
                </div>
                
            </div>
            
        </div>
        <div id="site-copyrights">
            <div class="container">
                <div class="row">
                        <div class="col-md-12">
                                © {{ date('Y') }} {{ $company->name }} - Tous droits réservés.<br>
                                <span class="creator">Site web créé via <a href="https://www.goexploria.com/" target="_blank">GoExploria.com</a></span>
                        </div>
                    
                </div>
                    
            </div>
        </div>
    </footer>
@endif
