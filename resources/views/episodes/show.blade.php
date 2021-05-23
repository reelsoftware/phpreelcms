@extends('layouts.frontend')

@section('meta_description', $episodes['current']->description)

@section('title')
    {{$episodes['current']->title}} - 
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.4/plyr.css" />
@endsection

{{--
* Index episodes:
* 0 = prevEpisode
* 1 = nextEpisode
* 2 = currentEpisode    
--}}

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if($episodes['current']->video_storage == 'vimeo')
                <div class="plyr__video-embed" id="player">
                    <iframe src="https://player.vimeo.com/video/{{$episodes['current']->video_name}}"></iframe>
                <div>
            @elseif($episodes['current']->video_storage == 's3' || $episodes['current']->video_storage == 'local')
                <video id="player" playsinline controls>
                    <source src="{{route('fileResource', ['fileName' => $episodes['current']->video_name, 'storage' => $episodes['current']->video_storage])}}">
                </video> 
            @elseif($episodes['current']->video_storage == 'youtube')
                <div class="plyr__video-embed" id="player">
                    <iframe src="https://www.youtube.com/embed/{{$episodes['current']->video_name}}"></iframe>
                <div>
            @endif
        </div>
    </div>

    <div class="row">
        
        @if($episodes['previous'] != null)
            <div class="col-6">
                <p class="text-center">
                    <a href="{{route('episodeShow', ['id' => $episodes['previous']['id']])}}" class="btn ne-previous-next-lesson ne-btn">{{__('Previous episode')}}</a>
                </p>
            </div>
        @endif

        <div class="col-6">
            @if($episodes['next'] != null)
                <p class="text-center">
                    <a href="{{route('episodeShow', ['id' => $episodes['next']['id']])}}" class="btn ne-previous-next-lesson ne-btn">{{__('Next episode')}}</a>
                </p>
            @else
                <p class="text-center">
                    <a href="{{route('seriesShow', ['id' => $episodes['current']['series_id']])}}" class="btn ne-previous-next-lesson ne-btn">{{__('Back to series')}}</a>
                </p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h1 class="ne-single-lesson-title pt-1">{{$episodes['current']->title}}</h1>
            <p class="ne-single-lesson-description">{{$episodes['current']->description}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="categories">{{__('Release date')}}: </span> 
            <a class="ne-movie-details" href="{{route('releaseShow', ['year' => $episodes['current']->year])}}">{{$episodes['current']->year}}</a>    
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
            <a class="ne-movie-details" href="{{route('ratingShow', ['grade' => $episodes['current']->rating])}}">{{$episodes['current']->rating}}</a>    
        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/player.js') }}"></script>
@endsection