@section('css')
	{{ Html::style('css/bootstrap.css') }}
  {{ Html::style('css/front/global.css') }}
	{{ Html::style('//fonts.googleapis.com/css?family=Lato:300,400,700') }}

	{{ Html::style('css/front/site/style.css') }}
    {{ Html::style('slick/slick.css') }}
    {{ Html::style('slick/slick-theme.css') }}
    {{ Html::style('css/front/site/amazonmenu.css') }}
	{{ Html::style('css/front/site/responsive.css') }}
	{{ Html::style('css/font-awesome.css') }}
	{{ Html::style('css/entypo.css') }}
	{{ Html::style("css/ekko-lightbox.css")}}

	<!-- CSS for IE -->
	<!--[if lte IE 9]>
	<link rel="stylesheet" type="text/css" href="css/front/ie.css" />
	<![endif]-->
  {{ Html::style('css/front/global_custom.css') }}
	{{ Html::style('css/front/site/custom.css') }}
	{{ Html::style('css/front/site/menu.css') }}


  {{ Html::style('css/front/site/' . $theme . '.css') }}

  @if (isset($configs) && isset($configs['fichier_css']) )
    {{ Html::style('css/front/site/' . $configs['fichier_css']) }}
  @endif

  @if( isset( $configs['theme_css'] ) )<style type="text/css">{!! $configs['theme_css'] !!}</style>
  @endif

@show
@section('javascript')
  {{ Html::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js') }}
  {{ Html::script('js/bootstrap/bootstrap.js') }}
  {{ Html::script('js/jquery-ui/ui.js') }}

  {{ Html::script('js/front/waypoints.js') }}
  {{ Html::script('js/validation/jsvalidation.js') }}
  {{ Html::script('js/toastr.js') }}

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      {{ Html::script('https://html5shiv.googlecode.com/svn/trunk/html5.js') }}
      {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js') }}
  <![endif]-->

  {{ Html::script('js/front/theme.js') }}
  {{ Html::script('js/ekko-lightbox.min.js') }}
  {{ Html::script('js/validation/jsvalidation.js') }}
  {{ Html::script('js/front/global.js') }}
  {{ Html::script('js/front/site/custom.js') }}
  {{ Html::script('js/front/site/amazonmenu.js') }}
  {{ Html::script('slick/slick.js') }}
@show
