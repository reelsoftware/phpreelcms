@extends('layouts.frontend')

@section('title')
    {{__('Release year')}} {{$year}} - 
@endsection

@section('content')
<div class="container ne-margin-top-under-nav">
    <div class="ne-h1">{{__('Release year')}} <i>{{$year}}</i></div>
    <div class="row">
        @foreach ($movies as $movie)
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card ne-card">
                <div class="ne-image-container">
                    <a href="
                        @if(with($movie)->getTable() == 'movies') 
                            {{route('movieShow', ['id' => $movie->id])}}
                        @elseif(with($movie)->getTable() == 'series') 
                            {{route('seriesShow', ['id' => $movie->id])}}     
                        @endif
                    ">
                        <img src="{{ route('fileResourceImage', ['fileName' => $movie->image_name, 'storage' => $movie->image_storage]) }}" class="card-img">

                    </a>

                    <div class="ne-image-container-bottom-right">
                        <span class="ne-movie-length">{{gmdate("H:i:s", $movie->length)}}</span><br>
                    </div>
                </div>      
                
                <div class="card-body">
                    <a href="
                        @if(with($movie)->getTable() == 'movies') 
                            {{route('movieShow', ['id' => $movie->id])}}
                        @elseif(with($movie)->getTable() == 'series') 
                            {{route('seriesShow', ['id' => $movie->id])}}     
                        @endif
                    " class="card-title ne-title">{{$movie->title}}</a>

                    <p class="card-text ne-short-description">{{mb_strimwidth($movie->description, 0, 120, "...")}}</p>
                    <a href="
                        @if(with($movie)->getTable() == 'movies') 
                            {{route('movieShow', ['id' => $movie->id])}}
                        @elseif(with($movie)->getTable() == 'series') 
                            {{route('seriesShow', ['id' => $movie->id])}}     
                        @endif
                    " class="ne-btn">{{__('Watch')}}</a>
                    
                    @if($subscribed == false)
                        <a href="{{route('subscribe')}}" class="ne-btn ne-movie-premium">{{__('subscribe')}}</a>
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

    <div class="row">
        <div class="col text-center">
            {{ $movies->links() }}
        </div>
    </div>
</div>

@endsection
