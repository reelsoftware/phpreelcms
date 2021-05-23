@extends('layouts.dashboard')

@section('title')
    Edit {{$translation['language']}} - 
@endsection

@section('pageTitle')
    Edit {{$translation['language']}}
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{ route('translationUpdate', ['id' => $translation['id']]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="language">Language</label>
                    <input type="text" name="language" class="form-control" id="language" value="{{ old('language') ? old('language') : $translation['language'] }}">
                    @error('language')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>           

                <h4 class="my-3">Translate the words</h4>

                @foreach($defaultFile as $enKey => $translateValue)
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 col-sm-4">
                                <label for="{{$loop->index}}">{{$enKey}}</label>
                            </div>

                            <div class="col-md-9 col-sm-8">
                                <input type="text" id="{{$loop->index}}" name="{{$loop->index}}" class="form-control" value="@if($loop->index < count($languageFile)){{$languageFile[$enKey]}}@endif">
                            </div>
                        </div>
                    </div>
                @endforeach
            
                <input type="submit" class="btn btn-primary my-2">
            </form>
        </div>
    </div>
</div>
@endsection