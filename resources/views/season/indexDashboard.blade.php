@extends('layouts.dashboard')

@section('title')
    All seasons - 
@endsection

@section('pageTitle')
    All seasons
@endsection

@section('content')
<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Season title</th>
            <th scope="col">Series title</th>
            <th scope="col">Created at</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($seasons as $season)
                <tr>
                    <th scope="row">{{$loop->index + 1}}</th>
                    <td>{{$season->title}}</td>
                    <td>{{$season->series_title}}</td>
                    <td>{{$season->created_at}}</td>
                    <td>
                        <a class="btn btn-primary my-2" href="{{route('seasonEdit', ['id' => $season->id])}}">
                            Edit
                        </a>

                        <a class="btn btn-primary my-2" href="{{route('episodesOrderEdit', ['id' => $season->id])}}">
                            Episode order
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>   
</div>
{{ $seasons->links() }}

@endsection
