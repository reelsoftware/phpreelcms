@extends('layouts.frontend')

@section('meta_description', '')

@section('title')
    {{__('Series')}} - 
@endsection

@section('content')
<div class="container ne-margin-top-under-nav">
    <div class="ne-h1">{{__('Latest series')}}</div>
    <div class="row">
        @foreach ($series as $movie)
            
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card ne-card">
                        <div class="ne-image-container">
                            <a href="{{route('seriesShow', ['id' => $movie->series_id])}}">
                                <img src="{{route('fileResource', ['fileName' => $movie->image_name, 'storage' => $movie->image_storage])}}" class="card-img">
                            </a>
                        </div>      
                        
                        <div class="card-body">
                            <a href="{{route('seriesShow', ['id' => $movie->series_id])}}" class="card-title ne-title">{{$movie->series_title}}</a>

                            <p class="card-text ne-short-description">{{mb_strimwidth($movie->series_description, 0, 120, "...")}}</p>
                            <a href="{{route('seriesShow', ['id' => $movie->series_id])}}" class="ne-btn">{{__('Watch')}}</a>
                            
                            @if($subscribed == false)
                                <a href="{{route('subscribe')}}" class="ne-btn ne-movie-premium">{{__('Subscribe')}}</a>
                            @endif

                        </div>
                    </div>
                    <!--EndCard-->
                </div>
                <!--EndCol-->

            <!--EndmoviePublic-->
        @endforeach    
    </div>
    <!--EndRow-->



    <div>
    </div>

    <div class="row">
        <div class="col text-center">
            {{ $series->links() }}
        </div>
    </div>
</div>

<div class="container-fluid ne-footer">
    <div class="row">
        <div class="offset-md-1 col-md-5">
            <a class="ne-footer-item" href="{{ route('home') }}">{{__('Home')}}</a><br>
            <a class="ne-footer-item" href="{{ route('movies') }}">{{__('Movies')}}</a><br>
            <a class="ne-footer-item" href="{{ route('series') }}">{{__('Series')}}</a><br>
            <a class="ne-footer-item" href="{{ route('subscribe') }}">{{__('Subscribe')}}</a><br>
        </div>
    </div>

    <div class="row">
        <div class="offset-md-1 col-md-11 ne-footer-item my-2">
            © {{date("Y")}} {{ config('app.name') }}
        </div>
    </div>
</div>
@endsection

