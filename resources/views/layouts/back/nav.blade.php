
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

			<!-- Taches -->
			<!-- <li>
				<a href="https://docs.google.com/spreadsheets/d/1PObBKqr280Xov9DAv2ZAC_xsZAPGvOffgb_N3FjiNEs/edit?usp=sharing" target="_blank">
					<i class="fa fa-calendar"></i>
					<span class="title">Document des tâches</span>
				</a>
			</li> -->

			<!-- Gestion -->
			<li class="has-sub">
				<a href="#">
					<i class="fa fa-database"></i>
					<span class="title">Gestion</span>
				</a>
				<ul>
					<!-- Destinations -->
					<li class="has-sub">
						<a href="#">
							<span class="title">Destinations</span>
						</a>
						<ul>
							<li>{{ link_to_route('location.map', 'Liste', [], ['class'=>'title']) }}</li>
							<li>{{ link_to_route('location.type.map', 'Types', [], ['class'=>'title']) }}</li>
							<li>{{ link_to_route('country.search', 'Pays', [], ['class'=>'title']) }}</li>
							<li>{{ link_to_route('continent.search', 'Continent', [], ['class'=>'title']) }}</li>
						</ul>
					</li>

					<!-- Activités -->
					<li class="has-sub">
						<a href="#">
							<span class="title">Activités</span>
						</a>
						<ul>
							<li>{{ link_to_route('activity.search', 'Liste', [], ['class'=>'title']) }}</li>
							<li>{{ link_to_route('activity.category.search', 'Catégories', [], ['class'=>'title']) }}</li>
						</ul>
					</li>

					<!-- Entreprises -->
					<li class="has-sub">
						<a href="#">
							<span class="title">Etablissements</span>
						</a>
						<ul>
							<li>{{ link_to_route('company.search', 'Liste', [], ['class'=>'title']) }}</li>
							<li>{{ link_to_route('users.meeting.search', 'Rendez-vous', [], ['class'=>'title']) }}</li>
						</ul>
					</li>

					<!-- Utilisateurs -->
					<li class="has-sub">
						<a href="#">
							<span class="title">Utilisateurs</span>
						</a>
						<ul>
							<li>{{ link_to_route('user.search', 'Liste', [], ['class'=>'title']) }}</li>
							<li>{{ link_to_route('user.waiting', 'En attente', [], ['class'=>'title']) }}</li>
							<li>{{ link_to_route('user.type.search', 'Types de comptes', [], ['class'=>'title']) }}</li>
						</ul>
					</li>

      	  <li class="has-sub">
						<a href="#">
							<span class="title">Galeries</span>
						</a>
						<ul>
							<li>{{ link_to_route('country.gallery.search', 'Pays', [], ['class'=>'title']) }}</li>
							<li>{{ link_to_route('location.gallery.search', 'Destinations', [], ['class'=>'title']) }}</li>
							<li>{{ link_to_route('company.gallery.search', 'Établissement', [], ['class'=>'title']) }}</li>
						</ul>
					</li>

					<!-- Newsletters -->
					<li class="has-sub">
						<a href="#">
							<span class="title">Newsletters</span>
						</a>
						<ul>
							<li>{{ link_to_route('newsletter.search', 'Liste', [], ['class'=>'title']) }}</li>
							<li>{{ link_to_route('newsletter.add', 'Nouvelle', [], ['class'=>'title']) }}</li>
							<li>{{ link_to_route('newsletter.history', 'Historique', [], ['class'=>'title']) }}</li>
						</ul>
					</li>
				</ul>
			</li>

			<!-- Configuration -->
			<li class="has-sub">
				<a href="#">
					<i class="fa fa-gear"></i>
					<span class="title">Configuration</span>
				</a>
				<ul>
					<li>{{ link_to_route('module.search', 'Modules', [], ['class'=>'title']) }}</li>
					<li>{{ link_to_route('content.index', 'Contenu', [], ['class'=>'title']) }}</li>
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

		<ul id="main-menu" class="main-menu">
			<!-- Dashboard -->
			<li>
				<a href="{{route('admin')}}">
					<i class="fa fa-dashboard"></i>
					<span class="title">Administration</span>
				</a>
			</li>

			<!-- Destinations -->
			<li class="has-sub">
				<a href="#">
					<i class="fa fa-globe"></i>
					<span class="title">Destinations</span>
				</a>
				<ul>
					<li>{{ link_to_route('location.map', 'Gestion', [], ['class'=>'title']) }}
					</li>
					<li>{{ link_to_route('location.type.map', 'Types', [], ['class'=>'title']) }}
					</li>
					<li>{{ link_to_route('country.search', 'Pays', [], ['class'=>'title']) }}
					</li>
					<li>{{ link_to_route('continent.search', 'Continent', [], ['class'=>'title']) }}
					</li>
				</ul>
			</li>

			<!-- Activités -->
			<li class="has-sub">
				<a href="#">
					<i class="fa fa-bicycle"></i>
					<span class="title">Activités</span>
				</a>
				<ul>
					<li>{{ link_to_route('activity.search', 'Gestion', [], ['class'=>'title']) }}
					</li>
					<li>{{ link_to_route('activity.category.search', 'Catégories', [], ['class'=>'title']) }}
					</li>
				</ul>
			</li>

			<!-- Entreprises -->
			<li class="has-sub">
				<a href="#">
					<i class="fa fa-dollar"></i>
						<span class="title">Etablissements</span>
				</a>
				<ul>
					<li>{{ link_to_route('company.search', 'Gestion', [], ['class'=>'title']) }}
					</li>
					<li>{{ link_to_route('company.import', 'Importation', [], ['class'=>'title']) }}
					</li>
					<li>
						{{ link_to_route('users.meeting.search', 'Rendez-vous', [], ['class'=>'title']) }}
					</li>
				</ul>
			</li>

			<!-- Utilisateurs -->
			<li class="has-sub">
				<a href="#">
					<i class="fa fa-users"></i>
					<span class="title">Utilisateurs</span>
				</a>
				<ul>
					<li>{{ link_to_route('user.search', 'Gestion', [], ['class'=>'title']) }}
					</li>
					<li>{{ link_to_route('user.waiting', 'En attente', [], ['class'=>'title']) }}
					</li>
					<li>{{ link_to_route('user.type.search', 'Types de comptes', [], ['class'=>'title']) }}
					</li>
				</ul>
			</li>

			<!-- Newsletters -->
			<li class="has-sub">
				<a href="#">
					<i class="fa fa-envelope"></i>
					<span class="title">Newsletters</span>
				</a>
				<ul>
					<li>{{ link_to_route('newsletter.search', 'Gestion', [], ['class'=>'title']) }}
					</li>
					<li>{{ link_to_route('newsletter.add', 'Nouvelle', [], ['class'=>'title']) }}
					</li>
					<li>{{ link_to_route('newsletter.history', 'Historique', [], ['class'=>'title']) }}
					</li>
				</ul>
			</li>

			<!-- Réglages -->
			<li class="has-sub">
				<a href="#">
					<i class="fa fa-gear"></i>
					<span class="title">Configuration</span>
				</a>
				<ul>
					<li>{{ link_to_route('module.search', 'Modules', [], ['class'=>'title']) }}
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>
