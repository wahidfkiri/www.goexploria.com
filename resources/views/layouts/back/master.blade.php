<!DOCTYPE html>
<html lang='fr'>
<!-- Header -->
<head>
    @include('layouts.back.header')
    @include('layouts.back.ressources')
    @yield('more_css')
</head>
<body class="page-body">
    <div class="page-container horizontal-menu with-sidebar sidebar-collapsed">
        <!-- Menu -->
      @if (Auth::user()->isAdmin())
	      @include('layouts.back.nav')
      @else
        @include('layouts.back.restricted-nav')
      @endif

	    <!-- Content -->
	    <section class="section-main  container">
	    	@foreach($errors->all() as $error)
                <p class="alert alert-danger">{{$error}}</p>
            @endforeach
		    @yield('content')
	    </section>

	    <!-- FOOTER -->
        <footer class="footer container-fluid">
	        @include('layouts.common.footer')
	    </footer>
	</div>

  <!-- Génération des messages pour l'utilisateur -->
  @include('layouts.common.notif')

  @yield('js')
</body>
</html>
