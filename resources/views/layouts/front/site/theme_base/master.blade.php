<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html lang="en" class="ie6"> <![endif]-->
<!--[if IE 7 ]>
<html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <!--<![endif]-->

<!-- Header -->
<head>
    @include('layouts.front.site.' . $theme . '.header')
    @include('layouts.front.site.' . $theme . '.ressources')
</head>

@if( isset($company) )
@if( isset($company_headImage) && !empty($company_headImage) )
<body id="go-theme" class="@yield('bodyclass') body-bg">
@else
<body id="go-theme" class="@yield('bodyclass') body-blk">
@endif
@endif
<div class="main-container container-fluid">
<!-- Menu
<header id="header"> -->
@include('layouts.front.site.' . $theme . '.nav')
<!-- </header> -->

<!-- content -->
<div id="home-content-section">
        <div class="container">
          <div class="row">
                <div class="content col-md-10">
                        @foreach($errors->all() as $error)
                        <p class="alert alert-danger">{{$error}}</p>
                    @endforeach
    
                    @if(Session::has('success'))
                      <p class="alert alert-success">{{ Session::get('success') }}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
    
                    @yield('content')
                </div>
          </div>
        </div>
</div>
<!-- end content -->

<!-- FOOTER -->

@include('layouts.front.site.' . $theme . '.footer')
</div>
</body>

<!-- Génération des messages pour l'utilisateur -->
@include('layouts.common.notif')

@yield('js')
</html>
