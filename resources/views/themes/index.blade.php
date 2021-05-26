@extends('layouts.dashboard')

@section('title')
    Themes - 
@endsection

@section('pageTitle')
    Themes
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{ route('themeUpdate') }}" method="POST">
                {{ csrf_field() }}
                <h2>Select theme</h2>
                <p><small>Once you set a custom theme make sure to code every single page of the frontend. In case you miss any page your application will not display properly. Check the documentation regarding theme creation for further details.</small></p>

                <div class="form-group">
                    <label for="theme">Selected theme</label><br>

                    <select name="theme" class="custom-select" id="theme">
                        @foreach ($directories as $directory)
                            <option value="{{$directory}}" @if(env('THEME') == $directory) selected @endif>{{$directory}}</option>    
                        @endforeach
                    </select>
                </div>

                <input type="submit" class="btn btn-primary my-2" value="Update">
            </form>
        </div>
    </div>
</div>
@endsection