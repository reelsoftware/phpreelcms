@extends('layouts.frontend')

@section('meta_description', '')

@section('title')
    Error code {{ $code }} - 
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col my-4">
            <h1 class="text-center ne-h1">Error code {{ $code }}</h1>
            <p class="text-center ne-short-description">{{ $message }}</p>
        </div>
    </div>
</div>
@endsection