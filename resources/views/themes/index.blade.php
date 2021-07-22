@extends('layouts.dashboard')

@section('title')
    Themes - 
@endsection

@section('pageTitle')
    Themes
    <span class="badge badge-pill badge-default">{{ count($themes) }}</span>

    <button type="button" class="btn btn-primary mx-1 btn-sm">Add theme</button>

    <input type="file" class="custom-file-input" id="resourceFile">

    <div class="progress mt-3 mb-1">
        <div id="progressBar" class="progress-bar" role="progressbar"></div>
    </div> 
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
         @foreach($themes as $theme)
            <div class="col-sm-6 col-lg-4">
                <div class="card" >
                    <img class="card-img-top" src="{{ $theme['cover'] }}" alt="Card image cap">

                    <div class="card-body">
                        <h5 class="card-title">{{ $theme['config']['Theme name'] }}</h5>
                        <p class="card-text">{{ $theme['config']['Description'] }}</p>

                        @if($theme['directoryName'] == config('app.theme'))
                            <span class="badge badge-pill badge-success badge-lg" style="font-size:12px">Active</span>
                        @else
                            <form action="{{ route('themeUpdate') }}" method="POST" id="formUpdate{{ $loop->index }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="theme" value="{{ $theme['directoryName'] }}">
                            </form>

                            <form action="{{ route('themeDestroy') }}" method="POST" id="formDestroy{{ $loop->index }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="theme" value="{{ $theme['directoryName'] }}">
                            </form>

                            <button type="submit" class="btn btn-info" value="Set as active" form="formUpdate{{ $loop->index }}">Set as active</button>
                            <button type="submit" class="btn btn-danger" value="Remove" form="formDestroy{{ $loop->index }}">Remove</button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection