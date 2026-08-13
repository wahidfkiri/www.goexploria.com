<!-- Footer -->
<footer class="footer">
    @yield ('newsletter')
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
                <div class="topbar">
                  <div class="right">
                    @yield('socialNetworks')
                  </div>
                </div>
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
</footer>
