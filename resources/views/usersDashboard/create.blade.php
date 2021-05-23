@extends('layouts.dashboard')

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{ route('translationStore') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="language">Language</label>
                    <input type="text" name="language" class="form-control" id="language" value="{{ old('language') }}">
                    @error('language')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>           

                <h4 class="my-3">Translate the words</h4>

                @foreach($languageFile as $enKey => $translateValue)
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 col-sm-4">
                                <label for="{{$enKey}}">{{$enKey}}</label>
                            </div>

                            <div class="col-md-9 col-sm-8">
                                <input type="text" id="{{$enKey}}" name="{{$enKey}}" class="form-control">
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