@extends('layouts.dashboard')

@section('title')
    Stripe settings - 
@endsection

@section('pageTitle')
    Stripe settings
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{ route('stripeUpdate') }}" method="POST">
                {{ csrf_field() }}
   
                <p><small>These fields are always empty. The Stripe keys are considered very sensitive information, thus this form will only let you update your keys and not view them.</small></p>

                <div class="form-group">
                    <label for="stripeKey">Stripe key</label>
                    <input type="text" name="stripeKey" class="form-control" id="stripeKey">
                    @error('stripeKey')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stripeSecret">Stripe secret</label>
                    <input type="text" name="stripeSecret" class="form-control" id="stripeSecret">
                    @error('stripeSecret')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stripeWebhookSecret">Stripe webhook secret</label>
                    <input type="text" name="stripeWebhookSecret" class="form-control" id="stripeWebhookSecret">
                    @error('stripeWebhookSecret')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <input type="submit" class="btn btn-primary my-2" value="Update">
            </form>
        </div>
    </div>
</div>
@endsection