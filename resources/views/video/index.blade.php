@extends('layouts.dashboard')

@section('title')
    All standalone videos - 
@endsection

@section('pageTitle')
    {{__('All standalone videos')}}    
@endsection

@section('content')
<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">URL</th>
            <th scope="col">Visibility</th>
            <th scope="col">Created at</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($videos as $video)
                <tr>
                    <th scope="row">{{$loop->index + 1}}</th>
                    <td>{{$video->title}}</td>
                    <td>{{$video->id}}</td>
                    <td>{{$video->public ? 'Public' : 'Private'}}</td>
                    <td>{{$video->created_at}}</td>
                    <td>
                        <a class="btn btn-primary my-2" href="{{route('videoEdit', ['id' => $video->id])}}">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>   
</div>
{{ $videos->links() }}

@endsection
