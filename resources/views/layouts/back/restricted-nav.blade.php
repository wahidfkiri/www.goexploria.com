
<!-- Barre du haut -->
<header class="navbar navbar-fixed-top">
	<div class="navbar-inner">

		<!-- Logo -->
		<div class="navbar-brand">
			{{link_to_route('index', 'GoExploria', [], ["target" => "_blank"])}}
		</div>

		<!-- Contenu -->
		<ul class="navbar-nav">
			<!-- Dashboard -->
			<li>
				<a href="{{route('admin')}}">
					<i class="fa fa-dashboard"></i>
					<span class="title">Administration</span>
				</a>
			</li>

			<!-- Entreprises -->
			<li class="has-sub">
				<a href="#">
					<i class="fa fa-database"></i>
					<span class="title">Mes Entreprises</span>
				</a>
				<ul>
          @foreach (Auth::user()->companies as $company)
          <li>
            <a href="{{ route( 'company.edit', $company->id )}}" class="title">
              {{ $company->name }}
            </a>
          </li>
          @endforeach

				</ul>
			</li>

			<li class="has-sub account">
				<a href="#">
					<i class="entypo-user"></i> {{Auth::user()->name}}
				</a>

				<ul>
					@include('layouts.common.profil')
					<li>{{ link_to_route('auth.logout', 'Déconnexion', [], ['class'=>'title']) }}</li>
				</ul>
			</li>

		</ul>

		<!-- Items à droite de la barre du haut -->
		<ul class="nav navbar-right pull-right">
			<!-- Edition du compte -->
			<li class="dropdown hidden-xs">
				<a href="#" class="dropdown-toggle icon-right" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="entypo-user"></i> {{Auth::user()->name}}
				</a>

				<ul class="dropdown-menu">
					@include('layouts.common.profil')
				</ul>
			</li>

			<!-- Déconnexion -->
			<li>
				<a href="{{ route('auth.logout')}} ">
					<i class="fa fa-sign-out"></i> Déconnexion
				</a>
			</li>

			<!-- Icone menu responsive -->
			<li class="visible-xs">
				<div class="horizontal-mobile-menu visible-xs">
					<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
						<i class="entypo-menu"></i>
					</a>
				</div>
			</li>
		</ul>
	</div>
</header>

<!-- Menu de gauche -->
<div class='sidebar-menu fixed'>
	<div class="sidebar-menu-inner">
		<header class='logo-env'>

			<!-- Titre menu -->
			<div class='logo'>
				Administration
			</div>

			<!-- Bouton pour afficher/masquer -->
			<div class="sidebar-collapse">
				<a href="#"  class="sidebar-collapse-icon">
					<i class="entypo-menu"></i>
				</a>
			</div>

		</header>

		
	</div>
</div>
