<!DOCTYPE html>
<html>
<head>
	 <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/material.css') }}" rel="stylesheet">
	<link href="{{ asset('css/ripples.css') }}" rel="stylesheet">
	<link href="{{ asset('css/roboto.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container">
		@yield('content')
	</div>

</body>
</html>