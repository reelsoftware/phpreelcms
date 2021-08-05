<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" type="text/css">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

	<!-- Icons -->
	<link href="{{asset('css/nucleo/css/nucleo.css')}}" rel="stylesheet">
	<link href="{{asset('css/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">

	<!-- Argon CSS -->
	<link type="text/css" href="{{asset('css/argon.min.css')}}" rel="stylesheet">

	<title>@yield('title'){{Config::get('app.name')}}</title>
  </head>
  <body>


	<!-- Sidenav -->
	<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
		<div class="scrollbar-inner">
		  <!-- Brand -->
		  <div class="sidenav-header  align-items-center">
			<a class="navbar-brand" href="javascript:void(0)">
			  	{{ config('app.name') }} dashboard
			</a>
		  </div>
		  <div class="navbar-inner">
			<!-- Collapse -->
			<div class="collapse navbar-collapse" id="sidenav-collapse-main">
			  <!-- Nav items -->
			  <ul class="navbar-nav">
				<li class="nav-item">
				  <a class="nav-link" href="{{route('dashboard')}}">
					<i class="ni ni-tv-2 text-primary"></i>
					<span class="nav-link-text">Dashboard</span>
				  </a>
				</li>
			  </ul>

				<!-- Movies -->
				{!! Menu::render('dashboard-nav', 'admin') !!}

			</div>
		  </div>
		</div>
	</nav>


	  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Navbar links -->


          <ul class="navbar-nav align-items-center  ml-auto ">
			<li class="nav-item d-xl-none">
				<!-- Sidenav toggler -->
				<div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
				  <div class="sidenav-toggler-inner" >
					<i class="ni ni-align-left-2 menu-toggle"></i>
				  </div>
				</div>
			  </li>
			  
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->name }}</span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">User settings</h6>
                </div>
                
				<a class="dropdown-item" href="{{ route('logout') }}"
				onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
					{{ __('Logout') }}
				</a>

				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>

              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>

	@yield('header')

	<div class="container-fluid py-4">
		<div class="row justify-content-center">
		  <div class=" col ">
			<div class="card">
			  <div class="card-header bg-transparent">
				<h3 class="mb-0">@yield('pageTitle')</h3>
			  </div>
			  <div class="card-body">
				<div class="row">
					@yield('content')
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
  </div>

	
    <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>

	<!-- Argon JS -->
  	<script src="{{asset('js/js-cookie/js.cookie.js')}}"></script>
	<script src="{{asset('js/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
	<script src="{{asset('js/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
	<!-- Optional JS -->
	<script src="{{asset('js/argon.min.js')}}"></script>
	
	@yield('script')
  </body>
</html>