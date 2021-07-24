@extends(get_theme_layout("layout"))


<x-meta-description :value="$item->description"/>

@section('title', "$item->title - " . get_app_name())


@section('style')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.4/plyr.css">
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            @vimeo($item->video_storage)
                <div class="plyr__video-embed" id="player">
                    <iframe src="{{ Asset::video($item->video_name, $item->video_storage) }}"></iframe>
                </div>
            @endvimeo

            @html5($item->video_storage)
                <video id="player" playsinline controls>
                    <source src="{{ Asset::video($item->video_name, $item->video_storage) }}">
                </video> 
            @endhtml5

            @youtube($item->video_storage)
                <div class="plyr__video-embed" id="player">
                    <iframe src="{{ Asset::video($item->video_name, $item->video_storage) }}"></iframe>
                </div>
            @endyoutube

        </div>
    </div>

    <div class="row">
        <div class="col">
            <h1 class="ne-single-lesson-title pt-1">
                {{$item->title}}
                <a href="{{ UrlRoutes::movieTrailer($item->id) }}" class="trailer"><i>{{__('Watch movie trailer')}}</i></a>
            </h1>
            <p class="ne-single-lesson-description">{{$item->description}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="categories">{{__('Release date')}}: </span> 
            <a class="ne-movie-details" href="{{ Categories::releaseUrl($item->year) }}">{{$item->year}}</a>    
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="categories">{{__('Genre')}}: </span> 
            @foreach ($genre as $g)
                @if($loop->index < count($genre) - 1)
                    <a class="ne-movie-details" href="{{ Categories::genreCategoryUrl($g) }}">{{$g}}, </a> 
                @else
                    <a class="ne-movie-details" href="{{ Categories::genreCategoryUrl($g) }}">{{$g}}</a> 
                @endif
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="categories">{{__('Cast')}}: </span> 
            @foreach ($cast as $actor)
                @if($loop->index < count($cast) - 1)
                    <a class="ne-movie-details" href="{{ Categories::castActorCategoryUrl($actor) }}">{{$actor}}, </a> 
                @else
                    <a class="ne-movie-details" href="{{ Categories::castActorCategoryUrl($actor) }}">{{$actor}}</a> 
                @endif
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="categories">{{__('Rating')}}: </span> 
            <span class="ne-movie-details"></span>
            <a class="ne-movie-details" href="{{ Categories::ratingCategoryUrl($item->rating) }}">{{$item->rating}}</a>    
        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>
    <script src="{{ Asset::js("player.js") }}"></script>
@endsection