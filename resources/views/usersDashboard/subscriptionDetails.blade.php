@extends('layouts.dashboard')

@section('title')
    Subscription details - 
@endsection

@section('pageTitle')
    Subscription details
@endsection

@section('content')
<div class="container">
    @if($subscription != null)
        @if($cancelAt == NULL)
            <div class="row">
                <div class="col-sm-2">
                    <p><b>Subscription status:</b></p>
                    <p><b>Renew date:</b></p>
                </div>

                <div class="col-sm-10">
                    <p>Active</p>
                    <p>{{$currentPeriodEnd}}</p>
                </div>
            </div> 
        @else
            <div class="row">
                <div class="col-sm-2">
                    <p><b>Subscription status:</b></p>
                    <p><b>Active until:</b></p>
                </div>

                <div class="col-sm-10">
                    <p>Canceled</p>
                    <p>{{$currentPeriodEnd}}</p>
                </div>
            </div> 
        @endif
    @else
    <div class="row">
        <div class="col-sm-2">
            <p><b>Subscription status:</b></p>
            <p><b>Renew date:</b></p>
        </div>

        <div class="col-sm-10">
            <p>None</p>
            <p>-</p>
        </div>
    </div> 
    @endif
</div>
@endsection


