@extends('layouts.frontend')

@section('title')
{{$planName}} - 
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <div class="ne-h1">{{$planName}}</div>

            <form method="POST" action="{{ route('subscribeStore') }}" class="card-form mt-3 mb-3">
                @csrf
                <input type="hidden" name="payment_method" class="payment-method">
                <input type="hidden" value="{{$name}}" name="plan">

                <div class="col-12">
                    <label class="ne-label">Name</label><br>
                    <input class="StripeElement mb-3" style="width: 100%" name="card_holder_name" placeholder="Card holder name" required>
                    <label class="ne-label">Card details</label><br>
                    <div id="card-element"></div>
                    <div id="card-errors" role="alert" class="ne-label"></div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn ne-btn pay">
                            Subscribe for {{$price/100}}{{$price%100 ? '.' . $price%100 : ''}} {{$currency}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    'use strict';
    let stripe = Stripe("{{ env('STRIPE_KEY') }}")
    let elements = stripe.elements()
    let style = {
        base: {
            color: '#32325d',
            fontFamily: '"Open Sans", sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    }
    let card = elements.create('card', {style: style})
    card.mount('#card-element')
    let paymentMethod = null
    $('.card-form').on('submit', function (e) {
        $('button.pay').attr('disabled', true)
        if (paymentMethod) {
            return true
        }
        stripe.confirmCardSetup(
            "{{ $intent->client_secret }}",
            {
                payment_method: {
                    card: card,
                    billing_details: {name: $('.card_holder_name').val()}
                }
            }
        ).then(function (result) {
            if (result.error) {
                $('#card-errors').text(result.error.message)
                $('button.pay').removeAttr('disabled')
            } else {
                paymentMethod = result.setupIntent.payment_method
                $('.payment-method').val(paymentMethod)
                $('.card-form').submit()
            }
        })
        return false
    });
</script>
@endsection
