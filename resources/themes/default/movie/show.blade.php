@extends('layouts.frontend')

@section('meta_description', $item->description)

@section('title', "$item->title - ")

@section('style')
    @styleCss('https://cdn.plyr.io/3.6.4/plyr.css', external)
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @vimeo($item->video_storage)
                <div class="plyr__video-embed" id="player">
                    @vimeoEmbed($item->video_name)
                </div>
            @endvimeo

            @html5($item->video_storage)
                <video id="player" playsinline controls>
                    @html5Source($item->video_name, $item->video_storage)
                </video> 
            @endhtml5

            @youtube($item->video_storage)
                <div class="plyr__video-embed" id="player">
                    @youtubeEmbed($item->video_name);
                </div>
            @endyoutube()

        </div>
    </div>

    <div class="row">
        <div class="col">
            <h1 class="ne-single-lesson-title pt-1">
                {{$item->title}}
                <a href="{{route('trailerMovieShow', ['id' => $item->id])}}" class="trailer"><i>{{__('Watch movie trailer')}}</i></a>
            </h1>
            <p class="ne-single-lesson-description">{{$item->description}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="categories">{{__('Release date')}}: </span> 
            <a class="ne-movie-details" href="{{route('releaseShow', ['year' => $item->year])}}">{{$item->year}}</a>    
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
            <a class="ne-movie-details" href="{{route('ratingShow', ['grade' => $item->rating])}}">{{$item->rating}}</a>    
        </div>
    </div>
</div>

@endsection

@section('script')
    @scriptJs("https://cdn.plyr.io/3.6.4/plyr.js", external)
    @scriptJs('player.js', local)
@endsection