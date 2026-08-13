<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6"> <![endif]-->
<!--[if IE 7 ]> <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <!--<![endif]-->

<!-- Header -->
<head>
@include('layouts.front.header')
@include('layouts.front.ressources')
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>  (adsbygoogle = window.adsbygoogle || []).push({    google_ad_client: "ca-pub-9911589587841602",    enable_page_level_ads: true  });</script>
</head>
<body id="page-wrapper" class="@yield('bodyclass')">

<!-- Popup de login -->
@include('layouts.front.auth')

<!-- Menu -->
<header id="header" class="">
@include('layouts.front.nav')
</header>

<!-- Content -->
<section class="section-main container">
  @if(isset($errors))
    @foreach($errors->all() as $error)
      <p class="alert alert-danger">{{$error}}</p>
    @endforeach
  @endif
@yield('content')
</section>

<!-- FOOTER -->
<footer class="footer container-fluid">
@include('layouts.common.footer')
</footer>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-1010496-17', 'auto');
  ga('send', 'pageview');
</script>

<!-- Génération des messages pour l'utilisateur -->
@include('layouts.common.notif')

@yield('js')
</body>
</html>
