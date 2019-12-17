<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">




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

      <!-- end: header -->
			@yield('contenu')

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
