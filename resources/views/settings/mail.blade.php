@extends('layouts.dashboard')

@section('title')
    Email settings - 
@endsection

@section('pageTitle')
    Email settings
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{ route('emailUpdate') }}" method="POST">
                {{ csrf_field() }}

                <h2>Email</h2>

                <div class="form-group">
                    <label for="mailer">Mailer</label><br>

                    <select name="mailer" class="custom-select" id="mailer" onchange="switchVideoOption()">
                        <option value="smtp" @if (old('mailer') == 'smtp' || $mailer == 'smtp') selected @endif>SMTP</option>
                    </select>
                </div>

                <div id="smtp">
                    <div class="form-group">
                        <label for="host">Mail host</label>
                        <input type="text" name="host" class="form-control" id="host" value="{{ old('host') ? old('host') : $host }}">
                        @error('host')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="port">Mail port</label>
                        <input type="text" name="port" class="form-control" id="port" value="{{ old('port') ? old('port') : $port }}">
                        @error('port')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="host">Mail username</label>
                        <input type="text" name="username" class="form-control" id="username" value="{{ old('username') ? old('username') : $username }}">
                        @error('username')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="host">Mail password</label>
                        <input type="password" name="password" class="form-control" id="password" value="{{ old('password') ? old('password') : $password }}">
                        @error('password')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fromAddress">Mail address to send from</label>
                        <input type="text" name="fromAddress" class="form-control" id="fromAddress" value="{{ old('fromAddress') ? old('fromAddress') : $fromAddress }}">
                        @error('fromAddress')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <input type="submit" class="btn btn-primary my-2" value="Update">
            </form>
        </div>
    </div>
</div>
@endsection