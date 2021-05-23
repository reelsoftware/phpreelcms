@extends('layouts.install')

@section('title', 'User')

@section('content')
<ul class="nav justify-content-center">
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
</ul>

<div class="container">
    <div class="row">
        <div class="col my-2">
            <form method="POST" action="{{route('storeUser')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="appName">Application name</label>
                    <input type="text" class="form-control" name="appName" value="{{ old('appName') }}">
                    @error('appName')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password">
                    @error('password')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                    @error('password_confirmation')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Finish</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

    if(document.getElementById('phpVersion'))
</script>
@endsection