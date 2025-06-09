<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>MyBot - Creative</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{ asset('template/css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<!-- Select2 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<style>
	#globalLoader {
		transition: opacity 0.3s ease;
	}
</style>

<body>
	<div class="wrapper">
        @include('admin.layouts.sidebar')

		<div class="main">
            @include('admin.layouts.header')
            @yield('content')
            @include('admin.layouts.footer')
		</div>
	</div>

	<!-- Global Loading Spinner -->
	<div id="globalLoader" style="position:fixed;top:0;left:0;width:100%;height:100%;background:white;z-index:1050;display:flex;justify-content:center;align-items:center;">
		<div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
			<span class="visually-hidden">Loading...</span>
		</div>
	</div>
    
	<script src="{{ asset('template/js/app.js') }}"></script>

	<!-- Select2 JS -->
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<script>
		window.addEventListener('load', function () {
			const loader = document.getElementById('globalLoader');
			if (loader) {
				loader.style.opacity = '0';
				setTimeout(() => loader.style.display = 'none', 300);
			}
		});

		function showLoader() {
    		document.getElementById('globalLoader').style.display = 'flex';
		}

		function hideLoader() {
			document.getElementById('globalLoader').style.display = 'none';
		}
	</script>

</body>

</html>