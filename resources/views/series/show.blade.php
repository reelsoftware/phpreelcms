
@if($content != null)
@section('meta_description', $content[0]['season']->series_description)

@section('title')
    {{$content[0]['season']->series_title}} - 
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="ne-h1">
                    {{$content[0]['season']->series_title}}
                    <span class="badge ne-course-length ne-time">{{gmdate("H:i", $seriesLength)}}</span>
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
                                    <img src="{{route('fileResource', ['fileName' => $series['season']->image_name, 'storage' => $series['season']->image_storage])}}" class="card-img">   
                                </div>

                                <div class="col-9 col-lg-10">
                                    <a href="#{{$series['season']->title}}">{{$series['season']->title}}</a>
                                    <span class="badge badge-secondary ne-chapter-length">{{gmdate("H:i", $seasonsLength[$series['season']->season_id])}}</span>
                                </div>
                            </div>
                        </div>
                    </h2>

                    <a href="{{route('trailerSeasonShow', ['id' => $series['season']->season_id])}}" class="ne-movie-details"><i>{{__('Watch seasons trailer')}}</i></a>

                    {{--Loop throughout all the episodes--}}
                    <div id="{{$series['season']->title}}">
                        @foreach ($series['episode'] as $episode)
                            <span class="badge badge-secondary ne-lesson-length">{{gmdate("H:i", $episode->length)}}</span>
                            <a href="{{route('episodeShow', ['id' => $episode->id])}}" class="ne-lesson-title">{{$episode->title}}</a>
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
            <h1 class="text-center ne-h1">{{__('Series is empty')}}</h1>
            <p class="text-center ne-short-description">{{__('Please add seasons and episodes')}}</p>
        </div>
    </div>
</div>
@endsection
@endif