@extends('layouts.dashboard')

@section('title')
    All movies - 
@endsection

@section('pageTitle')
    {{__('All movies')}}    
@endsection

@section('content')
<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Year</th>
            <th scope="col">Visibility</th>
            <th scope="col">Created at</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <th scope="row">{{$loop->index + 1}}</th>
                    <td>{{$movie->title}}</td>
                    <td>{{$movie->year}}</td>
                    <td>{{$movie->public ? 'Public' : 'Private'}}</td>
                    <td>{{$movie->created_at}}</td>
                    <td>
                        <a class="btn btn-primary my-2" href="{{route('movieEdit', ['id' => $movie->id])}}">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>   
</div>
{{ $movies->links() }}

@endsection
