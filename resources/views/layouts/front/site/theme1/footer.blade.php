<!-- Footer -->
<div class="container">
  @if( $page->name != 'Accueil' && $page->name != 'Home' )
    <!--div id="footer_newsletter">
      <h3>Infolettre</h3>
      <p>Inscrivez-vous à notre infolettre dès maintenant!</p>
      {{ Form::open(array('route' => array('front.site.newsletter.subscribe.post', $company->id ), 'method' => 'POST', 'id' => 'signupForm', 'class' => 'form-horizontal form-groups-bordered', 'autocomplete' => 'off')) }}
        {{ Form::text('name', null, ['class' => 'form-control', 'min'=>3, 'placeholder' => 'Votre nom...', 'id' => 'name']) }}
        {{ Form::text('mail', null, ['class' => 'form-control', 'min'=>0, 'placeholder' => 'Votre adresse courriel...', 'id' => 'email']) }}
        <br>
        {!! Form::submit('S\'abonner à notre infolettre', array('class'=>'send-btn')) !!}
        {!! app('captcha')->render($lang = 'fr'); !!}
      {{ Form::close() }}
    </div-->
  @endif

  <div class="row nav-footer">
    <div class="col-md-12 col-xs-12" style="text-align: center;">
    	  <a href="{{ url($company_domain) }}">Accueil</a>

        @if(isset($pages))
          @foreach($pages as $key => $value)
            &nbsp;&nbsp; <a href="{{ url($company_domain . $value->slug) }}">{{ $value->name }}</a>
          @endforeach
        @endif

        &nbsp;&nbsp;<a href="{{ url($company_domain . 'contact', [$company->slug, 'contact']) }}">Contact</a>
    </div>
  </div>

	<div class="row copyright">
		<div class="col-md-3 col-xs-3"></div>
		<div class="col-md-6 col-xs-6 center">&copy; {{ date('Y') }} {{ $company->name }} - Tous droits réservés.<br><span class="creator">Site web créé via <a href="http://www.goexploria.com/">GoExploria.com</a></span></div>
		<div class="col-md-3 col-xs-3 right">
			<!--
			 <ul class="icons">
				<li><a href="#" class="icon fa-2x fa-facebook"></a></li>
				<li><a href="#" class="icon fa-2x fa-twitter"></a></li>
				<li><a href="#" class="icon fa-2x fa-youtube"></a></li>
				<li><a href="#" class="icon fa-2x fa-pinterest"></a></li>
				<li><a href="#" class="icon fa-2x fa-instagram"></a></li>
			</ul>
      -->
		</div>
	</div>
</div>
