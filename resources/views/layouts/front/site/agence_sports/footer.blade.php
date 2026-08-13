<!-- Footer -->
{{-- insère le slider ici si non commenté --}}
<!-- Section Slick slider -->
@if( $medias->where('gcarousel', 1)->count() > 0 )
<section class="add_slider">
    <div class="center">
        @foreach( $medias->where('gcarousel', 1) as $media)
        <div class="">
            @if ($media->target != '')
                <a target="_blank" href="{{ $media->target }}">
            @endif
            @if ($media->photo)
                <img alt="{{ $media->name }}" title="{{ $media->name }} - {{ strtoupper($company->name) }}" src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}" alt="{{ $media->id }}">
            @endif
            @if ($media->target != '')
                </a>
            @endif
        </div>
        @endforeach
    </div>
</section>
@endif
{{-- @yield('slider') --}}
@if( isset($company) )
    @if( isset($company_footerImage) && !empty($company_footerImage) )
        <section class="section-footer" style="background-image:url({{ URL::asset('uploads/companies/'.$company->id.'/'. $company_footerImage) }});color:{{ $company->footer_text_color }};text-shadow:1px 1px 2px #000;">
    @else
        <section class="section-footer" style="background-color:#000;color:#fff;">
    @endif
@endif

    @if ($company->newsletter == 0)
    <div id="index_newsletter">
        <div class="container">
            <p>Inscrivez-vous à notre infolettre dès maintenant!</p>
            {{ Form::open(array('route' => array('front.company.newsletter.subscribe.post', $company->id), 'method' => 'POST', 'id' => 'signupForm', 'class' => 'form-horizontal form-groups-bordered', 'autocomplete' => 'off')) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'min'=>3, 'placeholder' => 'Votre nom...', 'id' => 'name']) }}
            {{ Form::text('mail', null, ['class' => 'form-control', 'min'=>6, 'placeholder' => 'Votre adresse courriel...', 'id' => 'mail']) }}
            <br>
            {!! Form::submit('S\'abonner', array('class'=>'send-btn')) !!}
            {!! app('captcha')->render($lang = 'fr'); !!}
            {{ Form::close() }}
        </div>
    </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
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
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                @if (isset( $company->socialNetworks ) && $company->socialNetworks->hasNetworks() )
                    <div class="wrapper-social-icon">
                        <div class="icons">
                            @foreach ($company->socialNetworks->getNetworks() as $network)
                                <a href="{{$company->socialNetworks[$network[0]]}}" target="_blank">
                                    <i class="fa {{$network[1]}} logo-{{$network[0]}}"
                                       aria-hidden="true"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if (isset($pictos) && !empty($pictos))
                    <div class="wrapper-social-icon wrapper-social-icon-pictos">
                        <div class="icons">
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
                        </div>
                    </div>
                @endif
                <div class="wrap-info-comp">
                    <span class="info_company tel">Téléphone: <a href="tel:{{$coordinate->tel}}">{{$coordinate->tel}}</a></span><br>
                    <span class="info_company mail">Courriel: <a href="mailto:{{$coordinate->mail}}">{{$coordinate->mail}}</a></span>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="text-center">
                © {{ date('Y') }} {{ $company->name }} - Tous droits réservés.<br>
                <span class="creator">Site web créé via <a href="http://www.goexploria.com/" target="_blank">GoExploria.com</a></span>
            </div>
        </div>
    </div>
</section>
