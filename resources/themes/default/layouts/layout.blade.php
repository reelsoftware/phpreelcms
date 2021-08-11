<!doctype html>
<html lang="en">
  	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		@yield('meta')

		<link rel="stylesheet" href="{{ Asset::css('app.css') }}">
		<link rel="stylesheet" href="{{ Asset::css('slider.css') }}">
		<link rel="stylesheet" href="{{ Asset::css('style.css') }}">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap">
		
		@yield('style')
		
		<title>@yield('title')</title>
	</head>

	<body>
		<nav class="navbar navbar-expand-lg navbar-dark">
			<div class="container">
				<a class="navbar-brand" href="{{ UrlRoutes::home() }}">
					{{ AppConfig::name() }}
				</a>

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="ne-nav-link nav-link active" href="{{ UrlRoutes::home() }}">
								{{ __('Home') }}
							</a>
						</li>

						<li class="nav-item">
							<a class="ne-nav-link nav-link active" href="{{ UrlRoutes::allMovies() }}">
								{{ __('Movies') }}
							</a>
						</li>

						<li class="nav-item">
							<a class="ne-nav-link nav-link active" href="{{ UrlRoutes::allSeries() }}">
								{{ __('Series') }}
							</a>
						</li>

						<li class="nav-item">
							<a class="ne-nav-link nav-link active" href="{{ UrlRoutes::subscribe() }}">
								{{ __('Subscribe') }}
							</a>
						</li>
					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav ml-auto">
						<form class="form-inline my-2 my-lg-0" method="post" action="{{ UrlRoutes::searchPost() }}">
							@csrf
							<input class="form-control mr-sm-2 nav-search-bar" type="search" placeholder="{{ __('Search') }}" aria-label="Search" name='query'>
						</form>

						<!-- Authentication Links -->
						@guest
							<li class="nav-item">
								<a class="nav-link" href="{{ UrlRoutes::login() }}">
									{{ __('Login') }}
								</a>
							</li>

							@if (Route::has('register'))
								<li class="nav-item">
									<a class="nav-link" href="{{ UrlRoutes::register() }}">
										{{ __('Register') }}
									</a>
								</li>
							@endif
							@else
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										{{ Auth::user()->name }} <span class="caret"></span>
									</a>

									<ul class="dropdown-menu ne-dropdown" aria-labelledby="navbarDropdown">
										<li>
											<a class="dropdown-item ne-dropdown-item" href="{{ UrlRoutes::user() }}">
												{{ __('Settings') }}
											</a>
										</li>

										<li>
											<a class="dropdown-item ne-dropdown-item" href="{{ UrlRoutes::logoutPost() }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
												{{ __('Logout') }}
											</a>
										</li>

										<form id="logout-form" action="{{ UrlRoutes::logoutPost() }}" method="POST" style="display: none;">
											@csrf
										</form>
									</ul>
								</li>
						@endguest
					</ul>
				</div>
				<!--EndCollapse-->
			</div>
			<!--EndContainer-->
		</nav>

		@yield('content')

		<script src="{{ Asset::js("jquery-3.6.0.min.js") }}"></script>
		<script src="{{ Asset::js("bootstrap.bundle.min.js") }}"></script>

		@yield('script')
	</body>
</html>