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
                @if($subscription != NULL)
                        @if($cancelAt == NULL)
                            <p class="ne-short-description">
                                {{__('The next payment is schedule for')}} {{$currentPeriodEnd}}
                            </p>
                        
                            <a href="{{route('subscribeCancel')}}" class="btn ne-btn">{{__('Cancel the subscription')}}</a>
                            <p class="ne-short-description" style="padding-top:5px;font-size:14px">
                                <i>{{__('*If you cancel now the subscription is still going to be active until')}} {{$currentPeriodEnd}}</i>
                            </p> 
                                
                        @else
                        <p class="ne-short-description">
                            <i>{{__('The subscription has been canceled. You will continue to have acces until')}} {{$currentPeriodEnd}}</i>
                        </p>
                        @endif
                @else
                    <p class="ne-short-description">
                        {{__('There are not any active subscriptions')}}
                    </p>
                @endif
            </div>

            @if(count($invoices) != 0)
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th scope="col">{{__('Date')}}</th>
                            <th scope="col">{{__('Total')}}</th>
                            <th scope="col">{{__('Receipt')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                                <td>{{ $invoice->total() }}</td>
                                <td><a href="/user/invoice/{{ $invoice->id }}">{{__('Download')}}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

