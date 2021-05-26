@extends('layouts.frontend')

@section('meta_description', $trailer->description)

@section('title')
    {{$trailer->title}} {{__('Trailer')}} - 
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.4/plyr.css" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if($trailer->video_storage == 'vimeo')
                <div class="plyr__video-embed" id="player">
                    <iframe src="https://player.vimeo.com/video/{{$trailer->video_name}}"></iframe>
                <div>
            @elseif($trailer->video_storage == 's3' || $trailer->video_storage == 'local')
                <video id="player" playsinline controls>
                    <source src="{{route('fileResource', ['fileName' => $trailer->video_name, 'storage' => $trailer->video_storage])}}">
                </video> 
            @elseif($trailer->video_storage == 'youtube')
                <div class="plyr__video-embed" id="player">
                    <iframe src="https://www.youtube.com/embed/{{$trailer->video_name}}"></iframe>
                <div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h1 class="ne-movie-details" style="padding-top:10px">{{__('Watching trailer for')}}:
                @if($trailer->series_title != null && $trailer->season_title != null)
                    <a class="ne-movie-details" href="{{route('seriesShow', ['id' => $trailer->series_id])}}">{{$trailer->series_title}} - {{$trailer->season_title}}</a> 
                @elseif($trailer->title != null)
                    <a class="ne-movie-details" href="{{route('movieShow', ['id' => $trailer->id])}}">{{$trailer->title}}</a> 
                @endif
            </h1>
        </div>
    </div> 
</div>

@endsection

@section('script')
    <script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/player.js') }}"></script>
@endsection