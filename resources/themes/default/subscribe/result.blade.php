@extends('layouts.frontend')

@section('meta_description', '')

@section('title')
    {{__('Subscription result')}} - 
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col my-4">
            @if($success == true)
                <h1 class="text-center ne-h1">
                    {{__('Thank you for subscribing')}}
                </h1>

                <p class="text-center ne-short-description">
                    {{__('Please enjoy your new subscription. Access the settings menu for more account details.')}}
                </p>
            @else
                <h1 class="text-center ne-h1">
                    {{__('Something went wrong')}}
                </h1>

                <p class="text-center ne-short-description">
                    {{__('You are either already subscribed or something just went wrong. Please try again!')}}
                </p>
            @endif
        </div>
    </div>
</div>
@endsection