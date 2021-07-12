@extends('layouts.dashboard')

@section('title')
    Edit {{$content['title']}} - 
@endsection

@section('pageTitle')
    Edit {{$content['title']}}  
@endsection

@section('content')

<div class="container">
    <form action="{{ route('movieUpdate', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" value="{{ old('title') ? old('title') : $content['title'] }}" required maxlength="255">
                        @error('title')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required maxlength="500">{{ old('description') ? old('description') : $content['description'] }}</textarea>
                        @error('description')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>            
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="year">Year</label>
                        <input type="number" name="year" class="form-control" id="year" value="{{ old('year') ? old('year') : $content['year'] }}" required min="0">
                        @error('year')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <input type="text" name="rating" class="form-control" id="rating" required maxlength="25" value="{{ old('rating') ? old('rating') : $content['rating'] }}">
                        @error('rating')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="length">Length</label>
                        <input type="text" name="length" class="form-control" id="length" required value="{{ old('length') ? gmdate("H:i", old('length')) : gmdate("H:i",$content['length']) }}" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" placeholder="e.g 01:10">
                        @error('length')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    
        
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cast">Cast</label>
                        <input type="text" name="cast" class="form-control" id="cast" value="{{ old('cast') ? old('cast') : $content['cast'] }}" required maxlength="500">
                        @error('cast')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <input type="text" name="genre" class="form-control" id="genre" value="{{ old('genre') ? old('genre') : $content['genre'] }}" required maxlength="500">
                        @error('genre')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        @uploadForm()
        
        <div class="container mt-1">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail</label>
    
                        <select id="thumbnail" name="thumbnail" class="custom-select">
                            <option></option>
                        </select>
    
                        @error('thumbnail')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
    
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="platformVideo">Select video platform</label><br>
    
                        <select name="platformVideo" class="custom-select" onchange="switchVideoOption('platformVideo', 'videoFields', true)" id="platformVideo">
                            <option value="{{config('app.storage_disk')}}" @if (old('platformVideo') == config('app.storage_disk') || $video['storage'] == config('app.storage_disk')) selected @endif>HTML5</option>
                            <option value="vimeo" @if (old('platformVideo') == "vimeo" || $video['storage'] == "vimeo") selected @endif>Vimeo</option>
                            <option value="youtube" @if (old('platformVideo') == "youtube" || $video['storage'] == "youtube") selected @endif>YouTube</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6" id="videoFields">
                    <div class="form-group" @if($video['storage'] == 'local' || $video['storage'] == 's3') style="display: none" @endif id="videoId">
                        <label for="videoIdField">Video ID</label><br>
                        <input type="text" name="videoId" class="form-control" id="videoIdField" @if($video['storage'] == 'youtube' || $video['storage'] == 'vimeo') value="{{ old('videoId') ? old('videoId') : $video['name'] }}" @endif>
                        @error('videoId')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="form-group" @if($video['storage'] == 'youtube' || $video['storage'] == 'vimeo') style="display: none" @endif id="uploadVideo">
                        <label for="video">Video</label>
    
                        <select id="video" name="video" class="custom-select">
                            <option></option>
                        </select>
                        
                        @error('video')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="platformTrailer">Select trailer platform</label><br>
    
                        <select name="platformTrailer" class="custom-select" onchange="switchVideoOption('platformTrailer', 'trailerFields', true)" id="platformTrailer">
                            <option value="{{config('app.storage_disk')}}" @if (old('platformTrailer') == config('app.storage_disk') || $trailer['storage'] == config('app.storage_disk')) selected @endif>HTML5</option>
                            <option value="vimeo" @if (old('platformTrailer') == "vimeo" || $trailer['storage'] == "vimeo") selected @endif>Vimeo</option>
                            <option value="youtube" @if (old('platformTrailer') == "youtube" || $trailer['storage'] == "youtube") selected @endif>YouTube</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6" id="trailerFields">
                    <div class="form-group" @if($trailer['storage'] == 'local' || $trailer['storage'] == 's3') style="display: none" @endif id="trailerId">
                        <label for="trailerIdField">Trailer video ID</label><br>
                        <input type="text" name="trailerId" class="form-control" id="trailerIdField" @if($trailer['storage'] == 'youtube' || $trailer['storage'] == 'vimeo') value="{{ old('trailerId') ? old('trailerId') : $trailer['name'] }}" @endif>
                        @error('trailerId')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="form-group" @if($trailer['storage'] == 'youtube' || $trailer['storage'] == 'vimeo') style="display: none" @endif id="uploadTrailer">
                        <label for="trailer">Trailer</label>
    
                        <select id="trailer" name="trailer" class="custom-select">
                            <option></option>
                        </select>
                        
                        @error('trailer')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

    
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="public">Select visibility</label><br>
    
                        <select name="public" class="custom-select" id="platform">
                            <option value="0" @if (old('public') == 0 || $content['public'] == 0) selected @endif>Private</option>
                            <option value="1" @if (old('public') == 1 || $content['public'] == 1) selected @endif>Public</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="availability">Availability</label><br>
    
                        <select name="availability" class="custom-select" onchange="updateAccess()" id="availability">
                            <option value="0" @if (old('availability') == 0 || $content['availability'] == 0) selected @endif>Subscription</option>
                            <option value="1" @if (old('availability') == 1 || $content['availability'] == 0) selected @endif>Free</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="container" id="access" style="display:none">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="access">Access</label><br>
    
                        <select name="access" class="custom-select">
                            <option value="0" @if (old('access') == 0 || $content['access'] == 0) selected @endif>Available without authentication</option>
                            <option value="1" @if (old('access') == 1 || $content['access'] == 0) selected @endif selected>Requires authentication to view the content</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <input type="submit" class="btn btn-primary my-2">
                </div>
            </div>
        </div>
    </form>

</div>
@endsection

@section('script')
    <script src="{{ URL::asset('js/switchVideoOption.js') }}"></script>

    <script>
        const url = "{{route('resourceStoreApi')}}";
        //chunk size in bytes (1MB)
        const chunkSize = {{env('CHUNK_SIZE')}} * 1000000; 
    </script>
    
    <script src="{{ URL::asset('js/upload.js') }}"></script>

@endsection