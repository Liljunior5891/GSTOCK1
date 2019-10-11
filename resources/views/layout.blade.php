<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>MECANO</title>
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
		<link rel="stylesheet" href="octopus/assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
        <link rel="stylesheet" href="octopus/assets/vendor/select2/select2.css" />
        <link rel="stylesheet" href="octopus/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
        <link rel="stylesheet" href="octopus/assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
        <link rel="stylesheet" href="octopus/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="octopus/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="octopus/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
		<link rel="stylesheet" href="octopus/assets/vendor/morris/morris.css" />
		<link rel="stylesheet" href="octopus/assets/vendor/pnotify/pnotify.custom.css" />
		<link rel="stylesheet" href="octopus/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="octopus/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="octopus/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
		<link rel="stylesheet" href="octopus/assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
		<link rel="stylesheet" href="octopus/assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
        <link rel="stylesheet" href="octopus/assets/vendor/morris/morris.css" />



        <!-- Theme CSS -->
		<link rel="stylesheet" href="octopus/assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="octopus/assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="octopus/assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="octopus/assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body>

		<section class="body">

			<!-- start: header -->
			@yield('contenu')
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="octopus/assets/images/logo.png" height="45" alt="JSOFT Admin" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>

				<!-- start: search & user box -->

				<div class="header-right">
					<span class="separator"></span>

					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">

							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@JSOFT.com">
								<span class="name"></span>
								<span class="role"></span>
							</div>

							<i class="fa custom-caret"></i>
						</a>

						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
                                    <a  class="modal-with-form btn btn-default" role="menuitem" tabindex="-1" href="#profile" class="mb-xs mt-xs mr-xs btn btn-default"><i class="fa fa-user"></i>Mon profil</a>

								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Verouiller  l'ecran</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href=""  onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Deconnexion</a>
                                    <form id="logout-form" action="" method="POST" style="display: none;">
                                        @csrf
                                    </form>
								</li>
							</ul>
						</div>
					</div>
				</div>
        @endhasanyrole



				<!-- end: search & user box -->
			</header>
			<!-- end: header -->
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
										<a href="*">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span><TABLE>TABLEAU DE BORD</TABLE></span>
										</a>
									</li>
                                        <li>
                                            <a href="">
                                                <i class="fa fa-users"></i>
                                                <span>UTILISATEURS</span>
                                            </a>
                                        </li>
									<li>
										<a href="">
											<i class="fa fa-university" aria-hidden="true"></i>
											<span>MAGASINS</span>
										</a>
									</li>
									<li>
										<a href="">
											<i class="fa fa-wrench"  aria-hidden="true"></i>
											<span>GARAGES</span>
										</a>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-globe" aria-hidden="true"></i>
											<span>EMPLACEMENTS</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="">
													 PAYS
												</a>
											</li>
											<li>
												<a href="">
													 VILLES
												</a>
											</li>
											<li>
												<a href="">
													 QUARTIERS
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-automobile" aria-hidden="true"></i>
											<span>VOITURES</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="">
													 MARQUES
												</a>
											</li>
											<li>
												<a href="">
													 MODELES
												</a>
											</li>
                                            @endrole
                                            @role('MAGASINIER')
                                            <li >
                                                <a href="">
                                                    <i class="fa fa-home" aria-hidden="true"></i>
                                                    <span><TABLE>TABLEAU DE BORD</TABLE></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <i class="fa fa-puzzle-piece"></i>
                                                    <span>PIECES</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <i class="fa  fa-shopping-cart"></i>
                                                    <span>VENTES</span>
                                                </a>
                                            </li>

                                            @endrole
                                            @role('GARAGISTE')
                                            <li class="nav-active">
                                                <a href="">
                                                    <i class="fa fa-home" aria-hidden="true"></i>
                                                    <span><TABLE>TABLEAU DE BORD</TABLE></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <i class="fa fa-thumbs-up"></i>
                                                    <span>SERVICES</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <i class="fa fa-users"></i>
                                                    <span>EMPLOYES</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <i class="fa  fa-gears (alias)"></i>
                                                    <span>PRESTATIONS</span>
                                                </a>
                                            </li>
                                            @endrole
										</ul>
									</li>
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
		<script src="octopus/assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="octopus/assets/vendor/select2/select2.js"></script>
		<script src="octopus/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="octopus/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="octopus/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		<script src="octopus/assets/vendor/pnotify/pnotify.custom.js"></script>
		<script src="octopus/assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="octopus/assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="octopus/assets/vendor/codemirror/mode/css/css.js"></script>
		<script src="octopus/assets/vendor/summernote/summernote.js"></script>
		<script src="octopus/assets/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
		<script src="octopus/assets/vendor/ios7-switch/ios7-switch.js"></script>
        <script src="octopus/assets/vendor/jquery-autosize/jquery.autosize.js"></script>
        <script src="octopus/assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
        <script src="octopus/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
        <script src="octopus/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
        <script src="octopus/assets/vendor/fuelux/js/spinner.js"></script>

        <script src="octopus/assets/vendor/raphael/raphael.js"></script>
        <script src="octopus/assets/vendor/morris/morris.js"></script>





        <!-- Theme Base, Components and Settings -->
		<script src="octopus/assets/javascripts/theme.js"></script>

		<!-- Theme Custom -->
		<script src="octopus/assets/javascripts/theme.custom.js"></script>

		<!-- Theme Initialization Files -->
		<script src="octopus/assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="octopus/assets/javascripts/dashboard/examples.dashboard.js"></script>
		<script src="octopus/assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="octopus/assets/javascripts/tables/examples.datatables.tabletools.js"></script>
		<script src="octopus/assets/javascripts/ui-elements/examples.modals.js"></script>
		<script src="octopus/assets/javascripts/forms/examples.advanced.form.js"></script>
        <script src="octopus/assets/javascripts/tables/examples.datatables.ajax.js"></script>
        <script src="octopus/assets/javascripts/ui-elements/examples.charts.js"></script>




    </body>
</html>
