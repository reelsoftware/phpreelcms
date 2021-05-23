@extends('layouts.install')

@section('title', 'Welcome to the installer')

@section('content')
<ul class="nav justify-content-center">
    <li class="nav-item dot done"></li>
    <li class="nav-item dot"></li>
    <li class="nav-item dot"></li>
    <li class="nav-item dot"></li>
    <li class="nav-item dot"></li>
</ul>

<div class="container">
    <div class="row">
        <div class="col my-2">
            <p>This is a simple 4 step instalation process that will cofigure your new installation in minutes. Click the button bellow to start!</p>
            <a href="{{route('installRequirements')}}" class="btn btn-primary">Begin installation</a>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

    if(document.getElementById('phpVersion'))
</script>
@endsection