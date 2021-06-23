@extends('layouts.install')

@section('title', 'Configure')

@section('content')
<ul class="nav justify-content-center">
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot"></li>
    <li class="nav-item dot"></li>
</ul>

<div class="container">

    config
    <div class="row">
        <div class="col my-2">
            <form method="POST" action="{{route('storeDatabase')}}">
                @csrf
                <div class="form-group">
                    <label for="hostname">Hostname</label>
                    <input type="text" class="form-control" name="hostname">
                    @error('hostname')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="port">Port</label>
                    <input type="text" class="form-control" name="port">
                    @error('port')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username">
                    @error('username')
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
                    <label for="databaseName">Database name</label>
                    <input type="text" class="form-control" name="databaseName">
                    @error('databaseName')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Next</button>
            </form>
        </div>
    </div>
</div>
@endsection