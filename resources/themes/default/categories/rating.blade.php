@extends(AppConfig::themeLayout("layout"))

@section('title')
    {{ __('Rating') }} {{ $grade }} - {{ AppConfig::name() }}
@endsection

@section('content')
    <div class="container ne-margin-top-under-nav">
        <div class="ne-h1">
            {{ __('Rating') }} <i>{{ $grade }}</i>
        </div>

        <div class="row">
            @foreach ($content as $item)
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card ne-card">
                        <div class="ne-image-container">
                            <a href="{{ Asset::item($item) }}">
                                <img src="{{ Asset::image($item->image_name, $item->image_storage) }}" class="card-img">
                            </a>
        
                            <div class="ne-image-container-bottom-right">
                                <span class="ne-movie-length">
                                    {{ Utilities::timeHMS($item->length) }}
                                </span><br>
                            </div>
                        </div>      
                        
                        <div class="card-body">
                            <a href="{{ Asset::item($item) }}" class="card-title ne-title">
                                {{ $item->title }}
                            </a>
        
                            <p class="card-text ne-short-description">
                                {{ Utilities::excerpt($item->description, 120, "...") }}
                            </p>

                            <a href="{{ Asset::item($item) }}" class="ne-btn">
                                {{ __('Watch') }}
                            </a>
                            
                            @if($subscribed == false)
                                <a href="{{ UrlRoutes::subscribe() }}" class="ne-btn ne-movie-premium">
                                    {{ __('subscribe') }}
                                </a>
                            @endif
        
                        </div>
                        <!--EndCardBody-->
                    </div>
                    <!--EndCard-->
                </div>
                <!--EndCol-->
            @endforeach     
        </div>
        <!--EndRow-->

        <div class="row">
            <div class="col text-center">
                {{ $content->links() }}
            </div>
        </div>
    </div>
    <!--EndContainer-->
@endsection