@section('styles')
	<link rel="stylesheet" href="{{ URL::to('src/css/common.css') }}" type="text/css">
<!-- will inject into styles section of other style sections where it is used -->
@append

@if (Session::has('fail'))
	<section class="info-box fail">
		{{ Session::get('fail') }}
	</section>
@endif

@if (Session::has('success'))
	<section class="info-box success">
		{{ Session::get('success') }}
	</section>
@endif

@if (count($errors) > 0)
	<section class="info-box fail">
		<ul>
			<!-- $errors is an object, not an array -->
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</section>
@endif