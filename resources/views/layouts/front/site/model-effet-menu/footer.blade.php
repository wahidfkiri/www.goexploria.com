<!-- Footer -->
<section class="section-footer">
    <div id="index_newsletter">
        <div class="container">
            <p>Inscrivez-vous à notre infolettre dès maintenant!</p>
            {{ Form::open(array('route' => array('front.company.newsletter.subscribe.post', $company->id), 'method' => 'POST', 'id' => 'signupForm', 'class' => 'form-horizontal form-groups-bordered', 'autocomplete' => 'off')) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'min'=>3, 'placeholder' => 'Votre nom...', 'id' => 'name']) }}
            {{ Form::text('mail', null, ['class' => 'form-control', 'min'=>6, 'placeholder' => 'Votre adresse courriel...', 'id' => 'mail']) }}
            <br>
            {!! Form::submit('S\'abonner', array('class'=>'send-btn')) !!}
         {{--   {!! app('captcha')->render($lang = 'fr'); !!}--}}
            {{ Form::close() }}
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <ul>
                    <li>
                        <a href="{{ url($company_domain) }}">Accueil</a>
                    </li>
                    @if(isset($pages))
                        @foreach($pages as $key => $value)
                            <li><a href="{{ url($company_domain . $value->slug) }}">{{ $value->name }}</a></li>
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
                    <div class="topbar">
                        <div class="right">
                            @foreach ($company->socialNetworks->getNetworks() as $network)
                                <a href="{{$company->socialNetworks[$network[0]]}}" target="_blank">
                                    <i class="fa {{$network[1]}} logo-{{$network[0]}}"
                                       aria-hidden="true"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="wrap-info-comp">
                    <span class="info_company tel">Téléphone: <a href="#">{{$coordinate->tel}}</a></span><br>
                    <span class="info_company mail">Courriel: <a href="mailto:">{{$coordinate->mail}}</a></span>
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