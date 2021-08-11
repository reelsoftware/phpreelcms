@extends('layouts.dashboard')

@section('title')
    Modules - 
@endsection

@section('pageTitle')
    Modules
    <span class="badge badge-pill badge-default">{{ Module::count(); }}</span>

    <label for="resourceFile">
        <span for="resourceFile" type="file" class="btn btn-primary mx-1 btn-sm">Add module</span>
    </label>

    <input style="display: none" type="file" class="custom-file-input" id="resourceFile">

    <small><i>*must be a .zip file</i></small>
    <div class="progress mt-3 mb-1">
        <div id="progressBar" class="progress-bar" role="progressbar"></div>
    </div> 
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
         @foreach($modules as $theme)
            @isset($theme['config'])
                <div class="col-sm-6 col-lg-4">
                    <div class="card" >
                        <img class="card-img-top" src="{{ $theme['cover'] }}" alt="Card image cap">

                        <div class="card-body">
                            <h5 class="card-title">{{ $theme['config']['Module name'] }}</h5>
                            <p class="card-text">{{ $theme['config']['Description'] }}</p>

                            @if(Module::collections()->has($theme['directoryName']))
                                <form action="{{ route('moduleUpdate') }}" method="POST" id="formUpdate{{ $loop->index }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="theme" value="{{ $theme['directoryName'] }}">
                                </form>

                                <button type="submit" class="btn btn-warning" value="Set as active" form="formUpdate{{ $loop->index }}">Disable</button>
                            @else
                                <form action="{{ route('moduleUpdate') }}" method="POST" id="formUpdate{{ $loop->index }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="theme" value="{{ $theme['directoryName'] }}">
                                </form>

                                <form action="{{ route('moduleDestroy') }}" method="POST" id="formDestroy{{ $loop->index }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="theme" value="{{ $theme['directoryName'] }}">
                                </form>

                                <button type="submit" class="btn btn-info" value="Set as active" form="formUpdate{{ $loop->index }}">Enable</button>
                                <button type="submit" class="btn btn-danger" value="Remove" form="formDestroy{{ $loop->index }}">Remove</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endisset
        @endforeach
    </div>
</div>
@endsection

@section('script')
    <script src="{{ URL::asset('js/upload.js') }}"></script>

    <script>
        new FileUpload("resourceFile", "{{route('resourceStoreApi', ['storage' => 'local'])}}", {{env('CHUNK_SIZE')}} * 1000000, function(fileId, fileName) {
            const httpRequest = new XMLHttpRequest();	
            httpRequest.open("POST", "{{ route('moduleStore') }}", true);
            
            httpRequest.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').content);

            httpRequest.onload = function () {
                document.getElementById("progressBar").style.width = "0%";
                location.reload();
		    };

            const form = new FormData();	
            form.append('fileId', fileId);

            httpRequest.send(form);
        });
    </script>
@endsection