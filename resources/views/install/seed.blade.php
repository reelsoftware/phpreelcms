@extends('layouts.install')

@section('title', 'Configure')

@section('content')
<ul class="nav nav-dots justify-content-center">
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
</ul>

<div class="container">
    <div class="row">
        <div class="col my-2">
            <form method="POST" action="{{route('storeSeed')}}">
                @csrf

                <div class="mb-2 form-group">
                    <label class="mb-1" for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 form-group">
                    <label class="mb-1" for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 form-group">
                    <label class="mb-1" for="password">Password</label>
                    <input type="password" class="form-control" name="password">
                    @error('password')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 form-group">
                    <label class="mb-1" for="password_confirmation">Confirm password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                    @error('password_confirmation')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>
                             
                <button type="submit" class="btn btn-primary">Next step</button>
            </form>
        </div>
    </div>
</div>
@endsection