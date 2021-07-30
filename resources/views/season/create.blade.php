@extends('layouts.dashboard')

@section('title')
    Create new season - 
@endsection

@section('pageTitle')
    Create new season
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{ route('seasonStore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-title-form type="create"/>
                        </div>

                        <div class="col-lg-12">
                            <x-description-form type="create"/>           
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <x-year-form type="create"/>    
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
                        <div class="col-md-12">
                            <x-thumbnail-form type="create"/>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <x-trailer-platform-form type="create"/>
                        </div>

                        <div class="col-md-6" id="trailerFields">
                            <x-trailer-form type="create"/>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-link-season-to-series-form type="create" :series="$series"/>
                        </div>
                    </div>
                </div>
                

                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-submit-form button-name="Add season"/>
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