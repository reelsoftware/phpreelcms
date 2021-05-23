@extends('layouts.dashboard')

@section('title')
    All translations - 
@endsection

@section('pageTitle')
    All translations
@endsection

@section('content')
<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Language</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($translations as $translation)
                <tr>
                    <th scope="row">{{$loop->index + 1}}</th>
                    <td>{{$translation->language}}</td>
                    <td>
                        <a class="btn btn-primary my-2" href="{{route('translationEdit', ['id' => $translation->id])}}" style="color:white;text-decoration:none;">
                            Edit
                        </a>

                        <a class="btn btn-danger my-2" href="{{route('translationDestroy', ['id' => $translation->id])}}" style="color:white;text-decoration:none;">
                            Delete
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>   
</div>
{{ $translations->links() }}

@endsection
