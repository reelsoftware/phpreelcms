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
            <form action="{{ route('episodeUpdate', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-title-form type="edit" :content="$content"/>
                        </div>
        
                        <div class="col-lg-12">
                            <x-description-form type="edit" :content="$content"/>                    
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <x-length-form type="edit" :content="$content"/>  
                        </div>         
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <x-upload-form/>
                        </div>
                    </div>
                </div>


                <div class="container mt-1">
                    <div class="row">
                        <div class="col-md-6">
                            <x-thumbnail-form type="edit"/>
                        </div>
                    </div>
                </div>
                
            
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <x-video-platform-form type="edit" :content="$video"/>           
                        </div>

                        <div class="col-md-6" id="videoFields">
                            <x-video-form type="edit" :content="$video"/>           
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <x-visibility-form type="edit" :content="$content"/>           
                        </div>

                        <div class="col-md-6">
                            <x-link-episode-to-season-form type="edit" :seasons="$seasons" :content="$content"/>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-availability-form type="edit" :content="$content"/>           
                        </div>
                    </div>
                </div>

                <div class="container" id="access" style="display:none">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-access-form type="edit" :content="$content"/>           
                        </div>
                    </div>
                </div>

                @if ($content['premium'] == 0)
                    <script>
                        document.getElementById('access').style.display = 'block';
                    </script>
                @endif
                
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-submit-form button-name="Edit episode"/>           
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
    <script src="{{ URL::asset('js/upload.js') }}"></script>

    <script>
        new FileUpload("resourceFile", "{{ route('resourceStoreApi') }}", {{ env('CHUNK_SIZE') }} * 1000000, function (fileId, fileName) {
            document.getElementById("progressBar").style.width = "0%";

            if(document.getElementById("uploadedFiles") != null)
                document.getElementById("uploadedFiles").innerHTML += '<p class="card-text">' + fileName + '</p>';

            if(document.getElementById("thumbnail") != null)
                document.getElementById("thumbnail").innerHTML += '<option value="' + fileId + '">' + fileName + '</option>';

            if(document.getElementById("video") != null)
                document.getElementById("video").innerHTML += '<option value="' + fileId + '">' + fileName + '</option>';

            if(document.getElementById("trailer") != null)
                document.getElementById("trailer").innerHTML += '<option value="' + fileId + '">' + fileName + '</option>';
        });
    </script>

@endsection