@extends('layouts.dashboard')

@section('title')
    Edit {{$content['title']}} - 
@endsection

@section('pageTitle')
    Edit {{$content['title']}}
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{ route('seasonUpdate', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="number" name="year" class="form-control" id="year" value="{{ old('year') ? old('year') : $content['year'] }}" required min="0">
                                @error('year')
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
                                <label for="platformTrailer">Select trailer platform</label><br>
            
                                <select name="platformTrailer" class="custom-select" onchange="switchVideoOption('platformTrailer', 'trailerFields', true)" id="platformTrailer">
                                    <option value="html5" @if (old('platformVideo') == "html5" || $trailer['storage'] == "html5") selected @endif>HTML5</option>
                                    <option value="vimeo" @if (old('platformVideo') == "vimeo" || $trailer['storage'] == "vimeo") selected @endif>Vimeo</option>
                                    <option value="youtube" @if (old('platformVideo') == "youtube" || $trailer['storage'] == "youtube") selected @endif>YouTube</option>
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
                                <label for="series_id">Link season to series</label><br>

                                <select name="series_id" class="custom-select" id="series_id">
                                    @foreach ($series as $s)
                                        <option value="{{$s->id}}" @if (old('series_id') == $s->id || $content['series_id'] == $s->id) selected @endif>{{$s->title}}</option>   
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="submit" class="btn btn-primary my-2" value="Edit season">
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
        //chunk size in bytes
        const chunkSize = {{env('CHUNK_SIZE')}} * 1000000; 
    </script>
    
    <script src="{{ URL::asset('js/upload.js') }}"></script>

@endsection