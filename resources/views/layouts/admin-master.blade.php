<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Area</title>

	<!-- URL Facade to(relative to public folder) -->
	<link rel="stylesheet" href="{{ URL::to('src/css/admin.css') }}">
	<!-- additional styles -->
	@yield('styles')
</head>
<body>
	@include('includes.admin-header')
	
	@yield('content')

	<script type="text/javascript">
		// full url to root for ajax calls
		// url segments can be added to it
		var baseUrl = "{{ URL::to('/') }}";
	</script>
	@yield('scripts')
</body>
</html>