@extends('layouts.master')

@section('title')
	Contact
@endsection

@section('styles')
	<link rel="stylesheet" href="{{ URL::to('src/css/form.css') }}">
@endsection

@section('content')
	@include('includes.info-box')
	<form action="{{ route('contact.send') }}" method="post" id="contact-form">
		<div class="input-group">
			<label for="name">Your Name</label>
			<input type="text" name="name" id="name" placeholder="Your Name" {{ $errors->has('name') ? 'class=has-error' : '' }} value="{{ Request::old('name') }}">
		</div>
		<div class="input-group">
			<label for="email">Your Email</label>
			<input type="text" name="email" id="email" placeholder="Your Email" {{ $errors->has('email') ? 'class=has-error' : '' }} value="{{ Request::old('email') }}">
		</div>
		<div class="input-group">
			<label for="subject">Subject</label>
			<input type="text" name="subject" id="subject" placeholder="Subject" {{ $errors->has('subject') ? 'class=has-error' : '' }} value="{{ Request::old('subject') }}">
		</div>
		<div class="input-group">
			<label for="message">Your Message</label>
			<textarea name="message" id="message" rows="10" placeholder="Your Message" {{ $errors->has('message') ? 'class=has-error' : '' }}>{{ Request::old('message') }}</textarea>
		</div>
		<button type="submit" class="btn">Submit Message</button>
		{!! csrf_field() !!}
	</form>
@endsection