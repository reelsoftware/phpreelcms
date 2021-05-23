@extends('layouts.install')

@section('content')
<ul class="nav justify-content-center">
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot"></li>
</ul>

<div class="container">
    <div class="row">
        <div class="col my-2">
            <form method="POST" action="{{route('storePayment')}}">
                @csrf
                <div class="form-group">
                    <label for="publicKey">Publishable Stripe key</label>
                    <input type="text" class="form-control" name="publicKey">
                    @error('publicKey')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="secretKey">Secret Stripe key</label>
                    <input type="text" class="form-control" name="secretKey">
                    @error('secretKey')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="secretKey">Signing secret Stripe key</label>
                    <input type="text" class="form-control" name="signingSecretKey">
                    @error('secretKey')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Next</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

    if(document.getElementById('phpVersion'))
</script>
@endsection