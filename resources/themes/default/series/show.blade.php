@extends(AppConfig::themeLayout("layout"))

@if($content != null)
    @section('meta')
        <meta name="description" content="{{ $content[0]['season']->series_description }}">
    @endsection

    @section('title')
        {{ $content[0]['season']->series_title }} - {{ AppConfig::name() }}
    @endsection

    @section('content')
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="ne-h1">
                        {{ $content[0]['season']->series_title }}
                        <span class="badge ne-course-length ne-time">
                            {{ Utilities::timeHMS($seriesLength) }}
                        </span>
                    </div>
                </div>
            </div>


            @foreach ($content as $series)
                {{--Add information about the season--}}
                <div class="row">
                    <div class="col card card-body ne-chapter-card">
                        <h2 class="ne-chapter-title">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-3 col-lg-2">
                                        <img src="{{ Asset::image($series['season']->image_name, $series['season']->image_storage) }}" class="card-img">   
                                    </div>

                                    <div class="col-9 col-lg-10">
                                        <a href="#{{ $series['season']->title }}">
                                            {{ $series['season']->title }}
                                        </a>

                                        <span class="badge badge-secondary ne-chapter-length">
                                            {{ Utilities::timeHMS($seasonsLength[$series['season']->season_id]) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </h2>
                        <a href="{{ UrlRoutes::seasonTrailer($series['season']->season_id) }}" class="ne-movie-details">
                            <i>{{ __('Watch seasons trailer') }}</i>
                        </a>

                        {{--Loop throughout all the episodes--}}
                        <div id="{{$series['season']->title}}">
                            @foreach ($series['episode'] as $episode)
                                <span class="badge badge-secondary ne-lesson-length">
                                    {{ Utilities::timeHMS($episode->length) }}
                                </span>

                                <a href="{{ UrlRoutes::episode($episode->id) }}" class="ne-lesson-title">
                                    {{ $episode->title }}
                                </a>
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
    @endsection
@else
    @section('content')
        <div class="container">
            <div class="row">
                <div class="col my-4">
                    <h1 class="text-center ne-h1">
                        {{ __('Series is empty') }}
                    </h1>

                    <p class="text-center ne-short-description">
                        {{ __('Please add seasons and episodes') }}
                    </p>
                </div>
            </div>
        </div>
    @endsection
@endif