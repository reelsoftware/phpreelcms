@extends('layouts.frontend')

@section('meta_description', '')

@section('title')
    {{__('Thank you')}} - 
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col my-4">
            <h1 class="text-center ne-h1">{{__('Thank you for subscribing')}}</h1>
            <p class="text-center ne-short-description">{{__('Please enjoy your new subscription. Access the settings menu for more account details.')}}</p>
        </div>
    </div>
</div>
@endsection