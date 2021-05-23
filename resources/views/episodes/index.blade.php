@extends('layouts.dashboard')

@section('title')
    All episodes - 
@endsection

@section('pageTitle')
    All episodes
@endsection

@section('content')
<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Season</th>
            <th scope="col">Visibility</th>
            <th scope="col">Created at</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($episodes as $episode)
                <tr>
                    <th scope="row">{{$loop->index + 1}}</th>
                    <td>{{$episode->title}}</td>
                    <td>{{$episode->season_title}}</td>
                    <td>{{$episode->public ? 'Private' : 'Public'}}</td>
                    <td>{{$episode->created_at}}</td>
                    <td>
                        <a class="btn btn-primary my-2" href="{{route('episodeEdit', ['id' => $episode->id])}}">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>   
</div>
{{ $episodes->links() }}

@endsection
