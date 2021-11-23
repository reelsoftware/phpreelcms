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
                <h1 class="ne-single-lesson-title pt-1">
                    {{ $item->title }}
                    <a href="{{ UrlRoutes::movieTrailer($item->id) }}" class="trailer">
                        <i>{{ __('Watch movie trailer') }}</i>
                    </a>
                </h1>

                <p class="ne-single-lesson-description">
                    {{ $item->description }}
                </p>
            </div>
        </div>

        @foreach ($categories as $category => $values)
            <div class="row">
                <div class="col">
                    <span class="categories">
                        {{ ucfirst($category) }}:
                    </span> 

                    @foreach ($values as $value)
                        @if($loop->index < count($values) - 1)
                            <a class="ne-movie-details" href="{{ Categories::categoryUrl($category, $value) }}">
                                {{ $value }}, 
                            </a> 
                        @else
                            <a class="ne-movie-details" href="{{ Categories::categoryUrl($category, $value) }}">
                                {{ $value }}
                            </a> 
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    <!--EndContainer-->
@endsection

@section('script')
    <script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>
    <script src="{{ Asset::js("player.js") }}"></script>
@endsection