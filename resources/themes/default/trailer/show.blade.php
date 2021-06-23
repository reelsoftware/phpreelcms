@extends('layouts.frontend')

@section('meta_description', $item->description)

@section('title')
    {{$item->title}} {{__('Trailer')}} - 
@endsection

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
            <h1 class="ne-movie-details" style="padding-top:10px">{{__('Watching trailer for')}}:
                @if($item->series_title != null && $item->season_title != null)
                    <a class="ne-movie-details" href="{{route('seriesShow', ['id' => $item->series_id])}}">{{$item->series_title}} - {{$item->season_title}}</a> 
                @elseif($item->title != null)
                    <a class="ne-movie-details" href="{{route('movieShow', ['id' => $item->id])}}">{{$item->title}}</a> 
                @endif
            </h1>
        </div>
    </div> 
</div>

@endsection

@section('script')
    @scriptJs("https://cdn.plyr.io/3.6.4/plyr.js", external)
    @scriptJs('player.js', local)
@endsection