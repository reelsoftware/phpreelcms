@extends('layouts.install')

@section('title', 'Welcome to the installer')

@section('content')
<ul class="nav justify-content-center mt-3">
    <li class="nav-item dot"></li>
    <li class="nav-item dot"></li>
    <li class="nav-item dot"></li>
    <li class="nav-item dot"></li>
</ul>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                <p>This is a simple 3 step installation process that will configure your new installation in minutes. Click the button bellow to start!</p>
                <a href="{{route('installRequirements')}}" class="btn btn-primary">Begin installation</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

    if(document.getElementById('phpVersion'))
</script>
@endsection
