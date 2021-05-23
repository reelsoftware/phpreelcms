@extends('layouts.dashboard')

@section('title')
    Seasons order - 
@endsection

@section('pageTitle')
    Seasons order
@endsection

@section('content')

@if($errors->any())
    <div class="alert alert-danger" role="alert">
        All order boxes should have a value
    </div>
@endif

<div class="container">
    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">Initial order</th>
            <th scope="col">Season title</th>
            <th scope="col">Set order</th>
            </tr>
        </thead>
        <tbody>
            <form action="{{route('seasonsOrderUpdate', ['id' => $id])}}" method="POST" id="formOrder">
                @csrf
                @foreach ($seasons as $season)
                    <tr>
                        <th scope="row">{{$loop->index + 1}}</th>
                        <td>{{$season->title}}</td>
                        <td>
                            <input type="hidden" name="order{{$loop->index}}" id="order{{$loop->index}}" value="">
                            <input type="hidden" name="season{{$loop->index}}" value="{{$season->id}}">
                            <a class="btn btn-primary my-2 white" id="orderBtn{{$loop->index}}" onclick="setOrder({{$loop->index}})">?</a>
                        </td>
                    </tr>
                @endforeach

                <input type="hidden" name="countSeasons" value="{{count($seasons)}}">
            </form>
        </tbody>
    </table>   

    <button class="btn btn-primary" type="submit" form="formOrder" value="Update order">Update order</button>
    <button class="btn btn-primary" onclick="resetOrder({{count($seasons)}})">Reset current order</button>
</div>
@endsection

@section('script')
    <script src="{{asset('js/order.js')}}"></script>
@endsection
