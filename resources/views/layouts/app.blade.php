<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
		<link href="{{asset('assets/vendor/fonts/circular-std/style.css')}}" rel="stylesheet">
		<link rel="stylesheet" href="{{asset('assets/libs/css/style.css')}}">
		<link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css')}}">
		<link rel="stylesheet" href="{{asset('assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/vendor/fonts/flag-icon-css/flag-icon.min.css')}}">
		@stack('custom-css')

		<title>{{config('app.name')}} - @yield('title', 'Home')</title>
	</head>

	<body>
		<div class="dashboard-main-wrapper">
			@include('partials.header')

			@include('partials.sidebar')

			<div class="dashboard-wrapper">
					<div class="dashboard-ecommerce">
						<div class="container-fluid dashboard-content ">
							@include('partials.breadcumb')

							@yield('content')

						</div>
					</div>

					@include('partials.footer')
				</div>
		</div>

		<script src="{{asset('assets/vendor/jquery/jquery-3.3.1.min.js')}}"></script>
		<!-- bootstap bundle js -->
		<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
		<!-- slimscroll js -->
		<script src="{{asset('assets/vendor/slimscroll/jquery.slimscroll.js')}}"></script>
		<!-- main js -->
		<script src="{{asset('assets/libs/js/main-js.js')}}"></script>
		<!-- chart c3 js -->
		@stack('custom-js')
	</body>
</html>