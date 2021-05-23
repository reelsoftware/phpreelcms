@extends('layouts.dashboard')

@section('title')
    App settings - 
@endsection

@section('pageTitle')
    App settings
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">           
            <form action="{{ route('appUpdate') }}" method="POST">
                {{ csrf_field() }}
                <h2>App settings</h2>
                
                <div class="form-group">
                    <label for="appName">App name</label>
                    <input type="text" name="appName" required class="form-control" id="chunkSize" value="{{ old('appName') ? old('appName') : $appName }}">
                    @error('appName')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <input type="submit" class="btn btn-primary my-2">
            </form>

        </div>
    </div>
</div>
@endsection

