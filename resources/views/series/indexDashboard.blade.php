@extends('layouts.dashboard')

@section('title')
    All series - 
@endsection

@section('pageTitle')
    All series
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
            @foreach ($series as $s)
                <tr>
                    <th scope="row">{{$loop->index + 1}}</th>
                    <td>{{$s->title}}</td>
                    <td>{{$s->year}}</td>
                    <td>{{$s->public ? 'Public' : 'Private'}}</td>
                    <td>{{$s->created_at}}</td>
                    <td>
                        <a class="btn btn-primary my-2" href="{{route('seriesEdit', ['id' => $s->id])}}">
                            Edit
                        </a>

                        <a class="btn btn-primary my-2" href="{{route('seasonsOrderEdit', ['id' => $s->id])}}">
                            Seasons order
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>   
</div>
{{ $series->links() }}
@endsection
