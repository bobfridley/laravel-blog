<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>

	<!-- URL Facade to(relative to public folder) -->
	<link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">
	<!-- additional styles -->
	@yield('styles')
</head>
<body>
	@include('includes.header')
	
	<div class="main">
		@yield('content')
	</div>

	@include('includes.footer')
</body>
</html>