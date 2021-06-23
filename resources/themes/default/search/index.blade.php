@extends('layouts.frontend')

@section('meta_description', '')

@section('title')
    {{__('Search')}} - 
@endsection

@section('content')
<div class="container ne-margin-top-under-nav">
    <div class="ne-h1">{{__('Results for ')}} <i>{{$query}}</i></div>
    <div class="row">
        @foreach ($results as $result)
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card ne-card">
                <div class="ne-image-container">
                    <a href="
                        @if($result->getTable() == 'movies') 
                            {{route('movieShow', ['id' => $result->id])}} 
                        @elseif($result->getTable() == 'series')
                            {{route('seriesShow', ['id' => $result->id])}} 
                        @endif
                    ">
                        <img src="{{ route('fileResourceImage', ['fileName' => $result->image_name, 'storage' => $result->image_storage]) }}" class="card-img">
                    </a>

                    @if($result->getTable() == 'movies') 
                        <div class="ne-image-container-bottom-right">
                            <span class="ne-movie-length">{{gmdate("H:i", $result->length)}}</span><br>
                        </div>
                    @endif
                </div>      
                
                <div class="card-body">
                    @if($result->getTable() == 'movies') 
                        <a href="{{route('movieShow', ['id' => $result->id])}}" class="card-title ne-title">{{$result->title}}</a>

                        <p class="card-text ne-short-description">{{mb_strimwidth($result->description, 0, 120, "...")}}</p>
                        <a href="{{route('trailerMovieShow', ['id' => $result->id])}}" class="ne-btn">{{__('Trailer')}}</a>
                    @elseif($result->getTable() == 'series')
                        <a href="{{route('seriesShow', ['id' => $result->id])}}" class="card-title ne-title">{{$result->title}}</a>

                        <p class="card-text ne-short-description">{{mb_strimwidth($result->description, 0, 120, "...")}}</p>
                        <a href="{{route('seriesShow', ['id' => $result->id])}}" class="ne-btn">{{__('Watch')}}</a>
                    @endif 
                    
                    @if($subscribed == false)
                        <a href="{{route('subscribe')}}" class="ne-btn ne-movie-premium">{{__('Subscribe')}}</a>
                    @endif

                </div>

                <div class="ne-card-bottom">
                    <div class="ne-card-bottom-text">
                        <p>{{$result->getTable() == 'movies' ? __('Movie') : __('Series')}}</p>
                    </div>
                </div>
            </div>
            <!--EndCard-->
        </div>
        <!--EndCol-->
        @endforeach    
    </div>
    <!--EndRow-->

    <div class="row">
        <div class="col text-center">
            {{ $results->links(env('THEME') . '.pagination.simple-pagination') }}
        </div>
    </div>
</div>

<div class="container-fluid ne-footer">
    <div class="row">
        <div class="offset-md-1 col-md-5">
            <a class="ne-footer-item" href="{{ route('home') }}">{{__('Home')}}</a><br>
            <a class="ne-footer-item" href="{{ route('movies') }}">{{__('Movies')}}</a><br>
            <a class="ne-footer-item" href="{{ route('series') }}">{{__('Series')}}</a><br>
            <a class="ne-footer-item" href="{{ route('subscribe') }}">{{__('Subscribe')}}</a><br>
        </div>
    </div>

    <div class="row">
        <div class="offset-md-1 col-md-11 ne-footer-item my-2">
            © {{date("Y")}} {{ config('app.name') }}
        </div>
    </div>
</div>
@endsection
