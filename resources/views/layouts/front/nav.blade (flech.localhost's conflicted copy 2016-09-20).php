<div class="topnav hidden-xs">
    <div class="container">
        <ul class="quick-menu pull-left">
            <li class="ribbon">
                <a href="#" id="langTitle">Français</a>
                <ul class="menu mini">
                    <li id="langElement"><a href="/lang/en" title="en">English</a></li>
                    <li id="langElement"><a href="/lang/fr" title="fr">Français</a></li>
                </ul>
            </li>
        </ul>



        <ul class="quick-menu pull-right">
            @if (Auth::guest())
            <li><a href="#travelo-login" id='login-button' class="soap-popupbox">Connexion</a></li>
            <li>{{ link_to_route('account.register', 'Inscription')}}</li>
            @else
            <li class='ribbon currency menu-color-skin'><a href='#'>{{Auth::user()->name}}</a>
                <ul class="menu mini">
                    @include('layouts.common.profil')
                </ul>
            </li>
            <li>{{ link_to_route('admin', "Administration")}}</li>
            <li>{{ link_to_route('auth.logout', "Déconnexion")}}</li>
            @endif
        </ul>

    </div>
</div>

<!-- begin MegaNavbar-->
<nav class="navbar navbar-blue-dark navbar-static-top" id="main_navbar" role="navigation">
	<div class="container-fluid">
             <a class="logo-exploria" href="/" title="Go Exploria"><img src="{!! URL::asset('images/LogoGoExploria.png') !!} "></a>

		<div class="navbar-header">                    
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-brand_size_lg">
			<span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="navbar-brand_size_lg">
			<ul class="nav navbar-nav navbar-left">

                <li class="dropdown-full">
                	<a data-toggle="dropdown" href="javascript:;" class="dropdown-toggle"><span class="rubrique-title">Destinations</span></a>
                	<div class="dropdown-menu" role="menu">
                            	<ul class="nav nav-tabs col-lg-3 col-md-3 col-sm-4 col-xs-12" role="tablist" style=" border-bottom: none;border-right: 1px solid #555;">
                                     <li>                                 
                                    {{ link_to_route('front.world', "Monde", [], ["class" => "custom-block"])}}
                                    </li>
                                    @foreach ($continents as $continent)
                                        <li role="presentation"><a href="#tab{{$continent->id}}" aria-controls="tab{{$continent->id}}" role="tab" data-toggle="tab">{{ $continent->name }}<i class="hidden-xs fa fa-angle-right pull-right"></i><span class="desc"><!-- Description here --></span></a></li>
                                    @endforeach                			
                		</ul>

                		<div class="tab-content col-lg-9 col-md-9  col-sm-8 col-xs-12 no-padding">

                                     @foreach ($continents as $continent)
                                     <!-- item -->
                                     <div role="tabpanel" class="tab-pane" id="tab{{ $continent->id }}">
                                         <ul class="nav nav-tabs col-lg-4 col-md-4 col-sm-6" role="tablist" style="float: left; border-bottom: none;border-right: 1px solid #555;">
                                             @foreach($countries as $country)
                                                @if($country->continent_id == $continent->id)
                                                    <li role="presentation" class="active"><a href="#tab11" aria-controls="tab{{$continent->id}}1" role="tab" data-toggle="tab">{{$country->name}}<i class="hidden-xs fa fa-angle-right pull-right"></i><span class="desc"><!-- Description here --></span></a></li>
                                                @endif
                                             @endforeach                					                					
                			</ul>
                                     </div>
                                     @endforeach      
                           
                		</div>
                	</div>
                </li>
			</ul>
		</div>
	</div>
</nav>
    
    <style id="style_tag">
    @media (max-width: 767px) {
        .nav-tabs {width: 100%!important;border-right: none!important;border-bottom: 1px solid #555!important;}
        .tab-content {width: 100%!important;padding-left: 0!important;}
    }

    .tab-pane {width: 100%!important;}
    .nav-tabs>li{padding: 0;margin-bottom: 0;}
    .nav-tabs>li:not([class*="col-"]) {width: 100%!important;}
    .nav-tabs>li>a, .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {margin-right: 0;border-radius: 0; border: none;}
    @media (min-width: 768px) {
      .navbar .dropdown-toggle {margin-bottom: -1px;border-bottom: 1px solid transparent!important;}
      .navbar.navbar-fixed-bottom .dropdown-toggle {margin-top: -1px;border-top: 1px solid transparent!important;}
    }
</style>

<script>
        //Start navbar toggle fix top bottom
        $(document).on('click', '.toggle_fixing', function(e) {
            e.preventDefault();
            if ($('#main_navbar').hasClass('navbar-fixed-top')) {
                $('#main_navbar').toggleClass('navbar-fixed-bottom navbar-fixed-top');
                $(this).children('i').toggleClass('fa-chevron-down fa-chevron-up');
            } else {
                $('#main_navbar').toggleClass('navbar-fixed-bottom');
                $(this).children('i').toggleClass('fa-chevron-down fa-chevron-up');
                if ($('#main_navbar').parent('div').hasClass('container')) $('#main_navbar').children('div').addClass('container').removeClass('container-fluid');
                else if ($('#main_navbar').parent('div').hasClass('container-fluid')) $('#main_navbar').children('div').addClass('container-fluid').removeClass('container');
                FixMegaNavbar(navHeight);
            }
            if ($('#main_navbar').hasClass('navbar-fixed-top')) {$('body').css({'margin-top': $('#main_navbar').height()+'px', 'margin-bottom': ''});}
            else if ($('#main_navbar').hasClass('navbar-fixed-bottom')) {$('body').css({'margin-bottom': $('#main_navbar').height()+'px', 'margin-top': ''});}
        })
        //End navbar toggle fix top bottom

    	//Start Fix MegaNavbar on scroll page
    	var navHeight = $('#main_navbar').offset().top;
    	FixMegaNavbar(navHeight);
    	$(window).bind('scroll', function() {FixMegaNavbar(navHeight);});

    	function FixMegaNavbar(navHeight) {
    	    if (!$('#main_navbar').hasClass('navbar-fixed-bottom')) {
    	        if ($(window).scrollTop() > navHeight) {
    	            $('#main_navbar').addClass('navbar-fixed-top')
    	            $('body').css({'margin-top': $('#main_navbar').height()+'px'});
    	            if ($('#main_navbar').parent('div').hasClass('container')) $('#main_navbar').children('div').addClass('container').removeClass('container-fluid');
    	            else if ($('#main_navbar').parent('div').hasClass('container-fluid')) $('#main_navbar').children('div').addClass('container-fluid').removeClass('container');
    	        }
    	        else {
    	            $('#main_navbar').removeClass('navbar-fixed-top');
    	            $('#main_navbar').children('div').addClass('container-fluid').removeClass('container');
    	            $('body').css({'margin-top': ''});
    	        }
    	    }
    	}
    	//End Fix MegaNavbar on scroll page


      // Tabs on hover
      $(function() {
          $('.dropdown, .dropdown-wide, .dropdown-full, .dropdown-short, .dropdown-grid')
              .mouseenter(function(){if (!('ontouchstart' in window)) $(this).addClass('open');})
              .mouseleave(function(){if (!('ontouchstart' in window)) $(this).removeClass('open');} )
              .click(function(e){if (!('ontouchstart' in window)) e.stopPropagation();});

          $('[data-toggle=tab]').mouseenter(function(e){
                e.preventDefault();
                $(this).tab('show');
                $(this).closest('.dropdown-menu').css({right:0});
          })
          $('[data-toggle=tab]').click(function(e){e.preventDefault();})

      });

    	//Next code used to prevent unexpected menu close when using some components (like accordion, tabs, forms, etc), please add the next JavaScript to your page
    	$( window ).load(function() {
    	    $(document).on('click', '.navbar .dropdown-menu', function(e) {e.stopPropagation();});
    	});
    </script>
    <!-- end MegaNavbar-->        


