@extends('layouts.frontend')

@section('title')
    {{__('Genre')}} {{$genre}} - 
@endsection


@section('content')
<div class="container ne-margin-top-under-nav">
    <div class="ne-h1">{{__('Genre')}} <i>{{$genre}}</i></div>
    <div class="row">
        @foreach ($content as $item)
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card ne-card">
                    <div class="ne-image-container">
                        <a href="@itemUrl($item, $item->id)">
                            <img src="@imageUrl($item->image_name, $item->image_storage) " class="card-img">
                        </a>

                        <div class="ne-image-container-bottom-right">
                            <span class="ne-movie-length">{{gmdate("H:i:s", $item->length)}}</span><br>
                        </div>
                    </div>      
                    
                    <div class="card-body">
                        <a href="@itemUrl($item, $item->id)" class="card-title ne-title">{{$item->title}}</a>

                        <p class="card-text ne-short-description">{{mb_strimwidth($item->description, 0, 120, "...")}}</p>
                        <a href="@itemUrl($item, $item->id)" class="ne-btn">{{__('Watch')}}</a>
                        
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
            {{ $content->links() }}
        </div>
    </div>
</div>

@endsection
