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
            <form action="{{ route('seriesUpdate', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="number" name="year" class="form-control" id="year" value="{{ old('year') ? old('year') : $content['year'] }}" required min="0">
                                @error('year')
                                    <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <input type="text" name="rating" class="form-control" id="rating" value="{{ old('rating') ? old('rating') : $content['rating'] }}" required maxlength="25">
                                @error('rating')
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="thumbnail">Thumbnail</label>
            
                                <select id="thumbnail" name="thumbnail" class="custom-select"></select>
            
                                @error('thumbnail')
                                    <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="public">Select visibility</label><br>
            
                                <select name="public" class="custom-select" id="platform">
                                    <option value="0" @if (old('public') == "0" || $content['public'] == "0") selected @endif>Private</option>
                                    <option value="1" @if (old('public') == "1" || $content['public'] == "1") selected @endif>Public</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
             
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="submit" class="btn btn-primary my-2" value="Edit series">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        const url = "{{route('resourceStoreApi')}}";
        //chunk size in bytes (1MB)
        const chunkSize = {{env('CHUNK_SIZE')}} * 1000000; 
    </script>
    
    <script src="{{ URL::asset('js/upload.js') }}"></script>
@endsection