@section('css')
	{{ Html::style('css/bootstrap.css') }}
  {{ Html::style('css/front/global.css') }}
	{{ Html::style('http://fonts.googleapis.com/css?family=Lato:300,400,700') }}
	{{ Html::style('css/front/animate.css') }}
	{{ Html::style('css/front/style.css') }}
	{{ Html::style('css/toastr.css') }}
	{{ Html::style('css/front/updates.css') }}
	{{ Html::style('css/front/responsive.css') }}
	{{ Html::style('css/font-awesome.css') }}
	{{ Html::style('css/entypo.css') }}
	{{ Html::style("css/selectize.css")}}
	{{ Html::style("css/ekko-lightbox.css")}}


	<!-- MegaNavBar
	{{ Html::style("js/megaNavbar/css/MegaNavbar.min.css")}}
	{{ Html::style("js/megaNavbar/css/skins/navbar-blue-dark.css")}}
	{{ Html::style("js/megaNavbar/css/animation/animation.css")}}
	-->

	<!-- CSS for IE -->
	<!--[if lte IE 9]>
	<link rel="stylesheet" type="text/css" href="css/front/ie.css" />
	<![endif]-->
  {{ Html::style('css/front/global_custom.css') }}
	{{ Html::style('css/common.css') }}
	{{ Html::style('css/front/custom.css') }}
	{{ Html::style('css/front/menu.css') }}

@show
@section('javascript')
  {{ Html::script('js/jquery/jquery-2.0.2.min.js') }}
  {{ Html::script('js/bootstrap/bootstrap.js') }}
  {{ Html::script('js/jquery-ui/ui.js') }}

  {{--
    {{ Html::script('js/jquery/stellar.min.js') }}
  --}}

  {{ Html::script('js/front/waypoints.js') }}

  {{ Html::script('js/validation/jsvalidation.js') }}
  {{ Html::script('js/toastr.js') }}
  {{ Html::script("js/selectize.js")}}
  {{ Html::script("js/search-engine.js")}}

 <!-- {{ Html::script("js/search-tool.js")}} -->

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      {{ Html::script('http://html5shiv.googlecode.com/svn/trunk/html5.js') }}
      {{ Html::script('http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js') }}
  <![endif]-->

  {{ Html::script('js/front/theme.js') }}
  {{ Html::script('js/ekko-lightbox.min.js') }}
  {{ Html::script('js/validation/jsvalidation.js') }}
  {{ Html::script('js/front/global.js') }}
  {{ Html::script('js/front/custom.js') }}

  <!-- {{ Html::script('js/revolution/min.js') }} -->

  @include('layouts.front.js')
@show
