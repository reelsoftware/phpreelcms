@extends('layouts.dashboard')

@section('title')
    Create new episode - 
@endsection

@section('pageTitle')
    Create new episode
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{ route('episodeStore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" required maxlength="255">
                                @error('title')
                                    <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required maxlength="500">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                                @enderror
                            </div>            
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="length">Length</label>
                                <input type="text" name="length" class="form-control" id="length" value="{{ old('length') }}" required pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" placeholder="e.g 01:10">
                                @error('length')
                                    <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="resourceFile" onchange="updateFileLabel('resourceFile')">
                                        <label class="custom-file-label" for="resourceFile">Upload files</label>
                                    </div>
                                </div>
                                    
                                <div class="progress">
                                    <div id="progressBar" class="progress-bar" role="progressbar"></div>
                                </div>   

                                <div class="card-body">
                                    <h5 class="card-title">Uploaded files</h5>

                                    <div id="uploadedFiles">
                                        <p class="card-text"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mt-1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="thumbnail">Thumbnail</label>
            
                                <select id="thumbnail" name="thumbnail" class="custom-select" required>
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
            
                                <select name="platformVideo" class="custom-select" onchange="switchVideoOption('platformVideo', 'videoFields')" id="platformVideo">
                                    <option value="html5" @if (old('platformVideo') == "html5") selected @endif>HTML5</option>
                                    <option value="vimeo" @if (old('platformVideo') == "vimeo") selected @endif>Vimeo</option>
                                    <option value="youtube" @if (old('platformVideo') == "youtube") selected @endif>YouTube</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6" id="videoFields">
                            <div class="form-group" style="display: none" id="videoId">
                                <label for="videoIdField">Video ID</label><br>
                                <input type="text" name="videoId" class="form-control" id="videoIdField" value="{{ old('videoId') }}">
                                @error('videoId')
                                    <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                                @enderror
                            </div>
            
                            <div class="form-group" id="uploadVideo">
                                <label for="video">Video</label>
            
                                <select id="video" name="video" class="custom-select" required>
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
                                <label for="public">Select visibility</label><br>
            
                                <select name="public" class="custom-select" id="platform">
                                    <option value="0" @if (old('public') == 0) selected @endif>Private</option>
                                    <option value="1" @if (old('public') == 1) selected @endif>Public</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="season_id">Link episode to season</label><br>
            
                                <select name="season_id" class="custom-select" id="season_id">
                                    @foreach ($seasons as $season)
                                        <option value="{{$season->id}}" @if (old('season_id') == $season->id) selected @endif>{{$season->series_title}} - {{$season->title}}</option>   
                                    @endforeach
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
                                    <option value="0" @if (old('availability') == 0) selected @endif>Subscription</option>
                                    <option value="1" @if (old('availability') == 1) selected @endif>Free</option>
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
                                    <option value="0" @if (old('access') == 0) selected @endif>Available without authentication</option>
                                    <option value="1" @if (old('access') == 1) selected @endif selected>Requires authentication to view the content</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="submit" class="btn btn-primary my-2" value="Create episode">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
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