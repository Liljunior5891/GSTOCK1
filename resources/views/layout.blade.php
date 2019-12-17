<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>GSTOCK</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
		<meta name="author" content="JSOFT.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->


		<!-- Vendor CSS -->
		<link rel="stylesheet" href="octopus/assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="octopus/assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="octopus/assets/vendor/magnific-popup/magnific-popup.css" />
        <link rel="stylesheet" href="octopus/assets/vendor/select2/select2.css" />



        <!-- Specific Page Vendor CSS -->



        <!-- Theme CSS -->
		<link rel="stylesheet" href="octopus/assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="octopus/assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="octopus/assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="octopus/assets/vendor/modernizr/modernizr.js"></script>
        @yield('css')
	</head>
	<body>

		<section class="body">
            <!-- start: header -->
            <header class="header">
                <div class="logo-container">
                    <a href="../" class="logo">
                        <img src="" height="45" alt="GSTOCK" />
                    </a>
                    <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                    </div>
                </div>

                <!-- start: search & user box -->
                <div class="header-right">
                    <a class="btn btn-danger" role="menuitem" tabindex="-1" href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Deconnexion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @yield('layoutCaisse')

                    <span class="separator"></span>

                     <div id="userbox" class="userbox">
                          <a  data-toggle="dropdown">
                                <figure class="profile-picture">
                                    <img src="/octopus/assets/images/login.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="/octopus/assets/images/login.jpg" />
                                </figure>
                                 <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@JSOFT.com">
                                     <span class="name">{{ Auth::user()->nom }} - {{ Auth::user()->prenom }}</span>
                                     @role('ADMINISTRATEUR')
                                    <span class="text-danger ">ADMINISTRATEUR </span>
                                     @endrole
                                     @role('CAISSIER')
                                    <span class="text-danger ">CAISSIER </span>
                                     @endrole
                                     @role('MAGASINIER')
                                    <span class="text-danger ">MAGASINIER </span>
                                     @endrole
                                </div>
                            </a>
                     </div>
                </div>
                <!-- end: search & user box -->
            </header>
      <!-- end: header -->
			@yield('contenu')

			<div class="inner-wrapper">

				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
					<div class="sidebar-header">
						<div class="sidebar-title">
							MENU
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>

					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
                                    @role('ADMINISTRATEUR')
									<li class="nav-active">
										<a href="{{route('bord')}}">
											<i class="fa  fa-dashboard (alias)" aria-hidden="true"></i>
											<span><TABLE>TABLEAU DE BORD</TABLE></span>
										</a>
									</li>
                                    <li>
                                        <a href="{{route('compte')}}">
                                            <i class="fa  fa-user" aria-hidden="true"></i>
                                            <span>MON COMPTE</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('utilisateurs')}}">
                                            <i class="fa fa-users"></i>
                                            <span>EMPLOYES</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('clients')}}">
                                            <i class="fa  fa-user"></i>
                                            <span>CLIENTS</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <i class="fa  fa-desktop"  aria-hidden="true"></i>
                                            <span>CAISSE</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('fournisseurs')}}">
                                            <i class="fa fa-child" aria-hidden="true"></i>
                                            <span>FOURNISSEURS</span>
                                        </a>
                                    </li>
                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa  fa-cubes" aria-hidden="true"></i>
                                            <span>STOCK</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="{{route('categories')}}">
                                                    CATEGORIES / FAMILLES
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('modeles')}}">
                                                    PRODUITS
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa   fa-truck" aria-hidden="true"></i>
                                            <span>APPROVISIONNEMENT</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="{{route('provisions')}}">
                                                    COMMANDES
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('livraisons')}}">
                                                    LIVRAISON
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li>
                                        <a href="{{route('ventes')}}">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                            <span>VENTES</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('historiques')}}">
                                            <i class="fa  fa-user" aria-hidden="true"></i>
                                            <span>HISTORIQUES</span>
                                        </a>
                                    </li>
                                    @endrole
                                    @role('CAISSIER')
                                    <li class="nav-active">
                                        <a href="{{route('caissebord')}}">
                                            <i class="fa  fa-dashboard (alias)" aria-hidden="true"></i>
                                            <span><TABLE>TABLEAU DE BORD</TABLE></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('compte')}}">
                                            <i class="fa  fa-user" aria-hidden="true"></i>
                                            <span>MON COMPTE</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('clients')}}">
                                            <i class="fa  fa-users"></i>
                                            <span>CLIENTS</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('ventes')}}">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                            <span>VENTES</span>
                                        </a>
                                    </li>
                                    @endrole
                                    @role('MAGASINIER')
                                    <li class="nav-active">
                                        <a href="{{route('magasinbord')}}">
                                            <i class="fa  fa-dashboard (alias)" aria-hidden="true"></i>
                                            <span><TABLE>TABLEAU DE BORD</TABLE></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('compte')}}">
                                            <i class="fa  fa-user" aria-hidden="true"></i>
                                            <span>MON COMPTE</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('fournisseurs')}}">
                                            <i class="fa fa-child" aria-hidden="true"></i>
                                            <span>FOURNISSEURS</span>
                                        </a>
                                    </li>
                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa  fa-cubes" aria-hidden="true"></i>
                                            <span>STOCK</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="{{route('categories')}}">
                                                    CATEGORIES / FAMILLES
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('modeles')}}">
                                                    PRODUITS
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa   fa-truck" aria-hidden="true"></i>
                                            <span>APPROVISIONNEMENT</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="{{route('provisions')}}">
                                                    COMMANDES
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('livraisons')}}">
                                                    LIVRAISON
                                                </a>
                                            </li>
                                    @endrole
								</ul>
							</nav>
						</div>
					</div>
				</aside>
			</div>
		</section>


		<!-- Vendor -->
		<script src="octopus/assets/vendor/jquery/jquery.js"></script>
		<script src="octopus/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="octopus/assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="octopus/assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="octopus/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="octopus/assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="octopus/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

		<!-- Specific Page Vendor -->

        <script src="octopus/assets/vendor/select2/select2.js"></script>



        <!-- Theme Base, Components and Settings -->
		<script src="octopus/assets/javascripts/theme.js"></script>

		<!-- Theme Custom -->
		<script src="octopus/assets/javascripts/theme.custom.js"></script>

		<!-- Theme Initialization Files -->
		<script src="octopus/assets/javascripts/theme.init.js"></script>
        @yield('js')

		<!-- Examples -->



@include('sweetalert::alert')
    </body>
</html>
