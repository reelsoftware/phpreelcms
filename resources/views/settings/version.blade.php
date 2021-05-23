@extends('layouts.dashboard')

@section('title')
    Update app - 
@endsection

@section('pageTitle')
    Update app
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <h2>Version</h2>
            <p>Current version: {{$appVersion}}</p>
            <a class="btn btn-primary" href="{{route('versionUpdate')}}">Update version</a>
        </div>
    </div>
</div>
@endsection

