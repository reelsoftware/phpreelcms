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
                @cardInfo($name)
        
                <label class="ne-label">Name</label><br>
                @cardName
                    
                <label class="ne-label">Card details</label><br>
                @card
                @cardError

                @cardSubmit("Subscribe")

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

    //Style for the card field
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
        },
        stripeElement: {
            boxSizing : 'border-box',
            color: '#32325d',
            height: '40px',
            padding: '10px 12px',
            border: '0px solid transparent',
            borderRadius: '4px',
            backgroundColor: 'white',
            boxShadow: '0 1px 3px 0 #e6ebf1',
            webkitTransform : 'box-shadow 150ms ease',
            transition: 'box-shadow 150ms ease',
            width: '100%',
            marginBottom: '10px'
        },
    }
   
    $('#cardName').css(style.stripeElement);

    let card = elements.create('card', {style: style})

    $('#cardName').focus(function() {
        $('#cardName').css('border','0px solid transparent');
    });

    card.mount('#card')
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
                    billing_details: {name: $('.cardHolderName').val()}
                }
            }
        ).then(function (result) {
            if (result.error) {
                $('#cardError').text(result.error.message)
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
