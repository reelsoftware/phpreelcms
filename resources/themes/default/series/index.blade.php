@extends(AppConfig::themeLayout("layout"))

@section('title')
    {{__('Series')}} - {{ AppConfig::name() }}
@endsection

@section('content')
<div class="container ne-margin-top-under-nav">
    <div class="ne-h1">{{ __('Latest series') }}</div>
    <div class="row">
        @foreach ($content as $item)
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card ne-card">
                        <div class="ne-image-container">
                            <a href="{{ UrlRoutes::series($item->series_id) }}">
                                <img src="{{ Asset::image($item->image_name, $item->image_storage) }}" class="card-img">
                            </a>
                        </div>      
                        
                        <div class="card-body">
                            <a href="{{ UrlRoutes::series($item->series_id) }}" class="card-title ne-title">{{ $item->series_title }}</a>

                            <p class="card-text ne-short-description">{{ Utilities::excerpt($item->series_description, 120, "...") }}</p>
                            <a href="{{ UrlRoutes::series($item->series_id) }}" class="ne-btn">{{ __('Watch') }}</a>
                            
                            @if($subscribed == false)
                                <a href="{{ UrlRoutes::subscribe() }}" class="ne-btn ne-movie-premium">{{ __('Subscribe') }}</a>
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
            {{ Utilities::pagination($content, 'simple-pagination') }}
        </div>
    </div>
</div>

<div class="container-fluid ne-footer">
    <div class="row">
        <div class="offset-md-1 col-md-5">
            <a class="ne-footer-item" href="{{ UrlRoutes::home() }}">
                {{ __('Home') }}
            </a><br>

            <a class="ne-footer-item" href="{{ UrlRoutes::allMovies() }}">
                {{ __('Movies') }}
            </a><br>

            <a class="ne-footer-item" href="{{ UrlRoutes::allSeries() }}">
                {{ __('Series') }}
            </a><br>

            <a class="ne-footer-item" href="{{ UrlRoutes::subscribe() }}">
                {{ __('Subscribe') }}
            </a><br>
        </div>
    </div>

    <div class="row">
        <div class="offset-md-1 col-md-11 ne-footer-item my-2">
            © {{ Utilities::currentYear() }} {{ AppConfig::name() }}
        </div>
    </div>
</div>
@endsection

