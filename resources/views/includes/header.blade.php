<header>
	<nav class="main-nav">
		<ul>
			<li{{ Request::is('blog') ? ' class=active' : '' }}><a href="{{ route('blog.index') }}">Blog</a></li>
			<li{{ Request::is('about') ? ' class=active' : '' }}><a href="{{ route('about') }}">About</a></li>
			<li{{ Request::is('contact') ? ' class=active' : '' }}><a href="{{ route('contact') }}">Contact</a></li>
			@if(!Auth::check())
				<li><a href="{{ route('admin.login') }}">Login</a></li>
			@else
				<li><a href="{{ route('admin.index') }}">Dashboard</a></li>
			@endif
		</ul>
	</nav>
</header>
