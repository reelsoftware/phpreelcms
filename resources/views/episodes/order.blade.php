@extends('layouts.dashboard')

@section('title')
    Episodes order - 
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
            <th scope="col">Episode title</th>
            <th scope="col">Set order</th>
            </tr>
        </thead>
        <tbody>
            <form action="{{route('episodesOrderUpdate', ['id' => $id])}}" method="POST" id="formOrder">
                @csrf
                @foreach ($episodes as $episode)
                    <tr>
                        <th scope="row">{{$loop->index + 1}}</th>
                        <td>{{$episode->title}}</td>
                        <td>
                            <input type="hidden" name="order{{$loop->index}}" id="order{{$loop->index}}" value="">
                            <input type="hidden" name="episode{{$loop->index}}" value="{{$episode->id}}">
                            <a class="btn btn-primary my-2 white" id="orderBtn{{$loop->index}}" onclick="setOrder({{$loop->index}})">?</a>
                        </td>
                    </tr>
                @endforeach

                <input type="hidden" name="countEpisodes" value="{{count($episodes)}}">
            </form>
        </tbody>
    </table>   

    <button class="btn btn-primary" type="submit" form="formOrder" value="Update order">Update order</button>
    <button class="btn btn-primary" onclick="resetOrder({{count($episodes)}})">Reset current order</button>
</div>
@endsection

@section('script')
    <script src="{{asset('js/order.js')}}"></script>
@endsection
