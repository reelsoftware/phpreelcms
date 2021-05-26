@extends('layouts.frontend')

@section('meta_description', $movie->description)

@section('title')
    {{$movie->title}} - 
@endsection

@section('style')
    @styleCssExternal('https://cdn.plyr.io/3.6.4/plyr.css')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if($movie->video_storage == 'vimeo')
                <div class="plyr__video-embed" id="player">
                    @vimeoEmbed($movie->video_name)
                </div>
            @elseif($movie->video_storage == 's3' || $movie->video_storage == 'local')
                <video id="player" playsinline controls>
                    @html5Source($movie->video_name, $movie->video_storage)
                </video> 
            @elseif($movie->video_storage == 'youtube')
                <div class="plyr__video-embed" id="player">
                    @youtubeEmbed($movie->video_name);
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h1 class="ne-single-lesson-title pt-1">
                {{$movie->title}}
                <a href="{{route('trailerMovieShow', ['id' => $movie->id])}}" class="trailer"><i>{{__('Watch movie trailer')}}</i></a>
            </h1>
            <p class="ne-single-lesson-description">{{$movie->description}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="categories">{{__('Release date')}}: </span> 
            <a class="ne-movie-details" href="{{route('releaseShow', ['year' => $movie->year])}}">{{$movie->year}}</a>    
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="categories">{{__('Genre')}}: </span> 
            @foreach ($genre as $g)
                @if($loop->index < count($genre) - 1)
                    <a class="ne-movie-details" href="{{route('genreShow', ['slug' => $g])}}">{{$g}}, </a> 
                @else
                    <a class="ne-movie-details" href="{{route('genreShow', ['slug' => $g])}}">{{$g}}</a> 
                @endif
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="categories">{{__('Cast')}}: </span> 
            @foreach ($cast as $actor)
                @if($loop->index < count($cast) - 1)
                    <a class="ne-movie-details" href="{{route('castShow', ['slug' => $actor])}}">{{$actor}}, </a> 
                @else
                    <a class="ne-movie-details" href="{{route('castShow', ['slug' => $actor])}}">{{$actor}}</a> 
                @endif
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="categories">{{__('Rating')}}: </span> 
            <span class="ne-movie-details"></span>
            <a class="ne-movie-details" href="{{route('ratingShow', ['grade' => $movie->rating])}}">{{$movie->rating}}</a>    
        </div>
    </div>
</div>

@endsection

@section('script')
    @scriptJsExternal('https://cdn.plyr.io/3.6.4/plyr.js')
    @scriptJsLocal('player')
@endsection