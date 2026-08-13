<!-- Footer -->
@if (isset($config_content))
@if ($config_content->footer_text)
	<div class="container">
		<div class="row copyright">
			<div class="col-md-3 col-xs-3">&nbsp;</div>
			<div class="col-md-6 col-xs-6 centered">{!! $config_content->footer_text !!}</div>
			<div class="col-md-3 col-xs-3 right">
			</div>
		</div>
	</div>
@endif
@endif

	<div class="container">
		<div class="row copyright">
			<div class="col-md-3 col-xs-3">&nbsp;</div>
			<div class="col-md-6 col-xs-6 centered">{{ date('Y') }} &copy; GoExploria ~ Tous droits réservés</div>
			<div class="col-md-3 col-xs-3 right">
				@if (isset($config_content))
				<ul class="icons">
					@if ($config_content->facebook_link)
						<li><a href="{{ $config_content->facebook_link }}" target="_blank" class="icon fa fa-2x fa-facebook"></a></li>
					@endif
					@if ($config_content->twitter_link)
						<li><a href="{{ $config_content->twitter_link }}" target="_blank" class="icon fa fa-2x fa-twitter"></a></li>
					@endif
					@if ($config_content->youtube_link)
						<li><a href="{{ $config_content->youtube_link }}" target="_blank" class="icon fa fa-2x fa-youtube-play"></a></li>
					@endif
					@if ($config_content->pinterest_link)
						<li><a href="{{ $config_content->pinterest_link }}" target="_blank" class="icon fa fa-2x fa-pinterest-p"></a></li>
					@endif
					@if ($config_content->instagram_link)
						<li><a href="{{ $config_content->instagram_link }}" target="_blank" class="icon fa fa-2x fa-instagram"></a></li>
					@endif
				</ul>
				@endif
			</div>

		</div>

	</div>