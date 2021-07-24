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

    <script>
        const url = "{{route('resourceStoreApi')}}";
        //chunk size in bytes (1MB)
        const chunkSize = {{env('CHUNK_SIZE')}} * 1000000; 
    </script>
    
    <script src="{{ URL::asset('js/upload.js') }}"></script>

@endsection