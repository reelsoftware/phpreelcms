@extends(AppConfig::themeLayout("layout"))

@section('meta')
    <meta name="description" content="{{ $item->description }}">
@endsection

@section('title')
    {{ $item->title }} - {{ AppConfig::name() }}
@endsection

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
                <h1 class="ne-movie-details" style="padding-top:10px">
                    {{ __('Watching trailer for') }}:
                    @if($item->series_title != null && $item->season_title != null)
                        <a class="ne-movie-details" href="{{ UrlRoutes::series($item->series_id) }}">
                            {{ $item->series_title }} - {{ $item->season_title }}
                        </a> 
                    @elseif($item->title != null)
                        <a class="ne-movie-details" href="{{ UrlRoutes::movie($item->id) }}">
                            {{ $item->title }}
                        </a> 
                    @endif
                </h1>
            </div>
        </div> 
    </div>
@endsection

@section('script')
    <script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>
    <script src="{{ Asset::js("player.js") }}"></script>
@endsection