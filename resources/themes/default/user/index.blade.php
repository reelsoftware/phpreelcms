@extends('layouts.frontend')

@section('title')
    {{__('User')}} - 
@endsection

@section('content')
<div class="container ne-margin-top-under-nav">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card-body">
                        <h5 class="card-title ne-title">{{__('Account information')}}</h5>
                        <p class="ne-short-description">{{__('Name')}}: {{$name}}</p>
                        <p class="ne-short-description">{{__('Email')}}: {{$email}}</p>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h5 class="card-title ne-title">{{__('Preferred language')}}</h5>
                <div class="row">
                    <div class="col-sm-6">
                        <form action="{{ route('userUpdateLanguage') }}" method="POST">
                            @csrf
                            <select class="custom-select" name="language">
                                <option value="0" {{ $language == null ? 'selected' : '' }}>{{__('English (Default)')}}</option>

                                @foreach($translations as $translation)
                                    <option value="{{$translation->language}}" {{ $language == $translation->language ? 'selected' : '' }}>{{$translation->language}}</option>
                                @endforeach
                            </select>

                            <input type="submit" class="btn ne-btn" style="margin-top:15px" value="{{__('Update language')}}">
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h5 class="card-title ne-title">{{__('Subscription details')}}</h5>
                @if($subscription == NULL)
                    <form action="{{ route('userManageSubscription') }}" method="POST">
                        @csrf
                        <input type="submit" class="btn ne-btn" value="{{__('Manage subscription')}}">
                    </form>
                @else
                    <p class="ne-short-description">
                        {{__('There are not any active subscriptions')}}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

