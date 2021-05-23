@extends('layouts.dashboard')

@section('title')
    Create new subscription plan - 
@endsection

@section('pageTitle')
    Create new subscription plan
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{ route('subscriptionPlanStore') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" min="1" step="0.01" name="price" class="form-control" id="price" value="{{ old('price') }}">
                    @error('price')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="currency">Currency</label><br>

                    <select name="currency" class="custom-select" id="currency">
                        @foreach ($currencies as $currency)
                            <option value="{{$currency}}" @if (old('subscriptionTypeId') == $currency) selected @endif>{{$currency}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="billingInterval">Billing interval</label><br>

                    <select name="billingInterval" class="custom-select" id="billingInterval">
                        <option value="day" @if (old('billingInterval') == 'day') selected @endif>Daily</option>
                        <option value="week" @if (old('billingInterval') == 'week') selected @endif>Weekly</option>
                        <option value="month" @if (old('billingInterval') == 'month') selected @endif>Monthly</option>
                        <option value="year" @if (old('billingInterval') == 'year') selected @endif>Yearly</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="benefits">Benefits (separated by ,)</label>
                    <textarea class="form-control" id="benefits" name="benefits" rows="3">{{ old('benefits') }}</textarea>
                    @error('benefits')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>  

                <div class="form-group">
                    <label for="public">Select visibility</label><br>

                    <select name="public" class="custom-select" id="platform">
                        <option value="0" @if (old('public') == 0) selected @endif>Private</option>
                        <option value="1" @if (old('public') == 1) selected @endif>Public</option>
                    </select>
                </div>

                <input type="submit" class="btn btn-primary my-2">
            </form>
        </div>
    </div>
</div>
@endsection