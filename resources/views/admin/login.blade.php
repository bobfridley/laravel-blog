@extends('layouts.admin-master')

@section('styles')
	<link rel="stylesheet" href="{{ URL::to('src/css/form.css') }}" type="text/css">
@endsection

@section('content')
	<div class="container">
		@include('includes.info-box')
		<form action="{{ route('admin.login') }}" method="post">
			<div class="input-group">
				<label for="email">E-Mail</label>
				<input type="text" name="email" id="email" {{ $errors->has('email') ? 'class=has-error' : '' }} value="{{ Request::old('email') }}" placeholder="E-Mail">
			</div>
			<div class="input-group">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" {{ $errors->has('password') ? 'class=has-error' : '' }} placeholder="Password">
			</div>
			<button class="btn" type="submit">Login</button>
			{{ csrf_field() }}
		</form>
	</div>
@endsection