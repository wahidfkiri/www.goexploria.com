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
        <body id="page-wrapper" class="@yield('bodyclass') body-bg"
              style="background-image:url({{ URL::asset('uploads/companies/'.$company->id.'/'. $company_headImage) }})">
        @else
            <body id="page-wrapper" class="@yield('bodyclass') body-blk">
            @endif
            @endif
            <!-- Menu -->
            <header id="header">
                @include('layouts.front.site.' . $theme . '.nav')
            </header>

            <!-- Content -->
            <section class="section-main container">
                @foreach($errors->all() as $error)
                    <p class="alert alert-danger">{{$error}}</p>
                @endforeach

                @if(Session::has('success'))
                  <p class="alert alert-success">{{ Session::get('success') }}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif

                @yield('content')
            </section>

            <!-- FOOTER -->
            <footer class="footer container-fluid">
                @include('layouts.front.site.' . $theme . '.footer')
            </footer>
            </body>

            <!-- Génération des messages pour l'utilisateur -->
        @include('layouts.common.notif')

        @yield('js')
</html>
