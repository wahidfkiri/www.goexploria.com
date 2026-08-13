<!DOCTYPE html lang='fr'>

<!-- Header -->
<head>
    @include('layouts.mail.header')
    @include('layouts.mail.ressources')
</head>
<body>    
    <nav>
        @include('layouts.mail.nav')
    </nav>
    <!-- Content -->
    <section>
        @if(isset($user->name))
            <p>Bonjour {{ucfirst($user->name)}},</p>
        @endif
        @yield('content')
        @if(isset($user->name))
        <p>Merci d'utiliser nos services !</p>
        <p>L'équipe GoExploria</p>
        @endif
    </section>

	
	<!-- FOOTER -->
    <footer>
	   @include('layouts.mail.footer')
	</footer>
</body>
</html>
