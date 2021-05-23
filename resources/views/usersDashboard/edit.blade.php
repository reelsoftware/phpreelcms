@extends('layouts.dashboard')

@section('title')
    Edit {{$user['name']}} - 
@endsection

@section('pageTitle')
    Edit {{$user['name']}}
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{ route('usersUpdate', ['id' => $user['id']]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') ? old('name') : $user['name'] }}">
                    @error('name')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>  
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" value="{{ old('email') ? old('email') : $user['email'] }}">
                    @error('email')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="roles">Role</label><br>

                    <select name="roles" class="custom-select" id="roles" value="{{ old('roles') ? old('roles') : $user['roles'] }}">
                        <option value="user" @if (old('roles') == "user" || $user['roles'] == "user") selected @endif>User</option>
                        <option value="admin" @if (old('roles') == "admin" || $user['roles'] == "admin") selected @endif>Administrator</option>
                    </select>
                </div>

                <input type="submit" class="btn btn-primary my-2">
            </form>
        </div>
    </div>
</div>
@endsection