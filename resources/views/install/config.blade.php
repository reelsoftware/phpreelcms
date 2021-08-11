@extends('layouts.install')

@section('title', 'Configure')

@section('content')
<ul class="nav nav-dots justify-content-center mt-2">
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot"></li>
</ul>

<div class="container">
    <div class="row">
        <div class="col">
            <form method="POST" action="{{route('storeConfig')}}">
                @csrf

                <nav>
                    <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
                        @foreach ($envFields as $section => $envField)
                            <button class="nav-link {{$loop->index == 0 ? 'active' : ''}}" id="nav-{{ str_replace(" ", "_", $section) }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ str_replace(" ", "_", $section) }}" type="button" role="tab" aria-controls="nav-{{ str_replace(" ", "_", $section) }}" aria-selected="true">{{ $section }}</button>
                        @endforeach        
                    </div>
                </nav>
                
                <div class="tab-content" id="nav-tabContent">
                    @foreach ($envFields as $section => $envField)
                        <div class="tab-pane fade {{$loop->index == 0 ? 'active show' : ''}}" id="nav-{{ str_replace(" ", "_", $section) }}" role="tabpanel" aria-labelledby="nav-{{ str_replace(" ", "_", $section) }}-tab">
                            @foreach ($envField as $env)
                                    <div class="mb-2 form-group">
                                        <label class="mb-1" for="{{$env}}">{{ucfirst(strtolower(str_replace("_", " ", $env)))}}</label>
                                        
                                        @if($env == "APP_ENV")
                                            <select class="form-select" name="{{$env}}">
                                                <option value="production">Production</option>
                                                <option value="local">Local</option>
                                                <option value="testing">Testing</option>
                                            </select>

                                            <div class="form-text">
                                                Leave as production if you plan on publicly sharing your website
                                            </div>
                                        @elseif($env == "APP_DEBUG")
                                            <select class="form-select" name="{{$env}}">
                                                <option value="false">False</option>
                                                <option value="true">True</option>
                                            </select>

                                            <div class="form-text">
                                                Leave as false if you plan on publicly sharing your website
                                            </div>
                                        @else
                                            <input type="text" class="form-control" name="{{$env}}" {{$env != 'DB_PASSWORD' ? 'required' : ''}}>
                                        @endif

                                        @error($env)
                                            <div class="alert alert-danger py-2 my-2">
                                                {{ ucfirst(strtolower(str_replace("_", " ", $env))) }} is required
                                            </div>
                                        @enderror
                                    </div>
                            @endforeach
                        </div>
                    @endforeach       
                </div>
                
                <button type="submit" class="btn btn-primary">Next step</button>
            </form>
        </div>
    </div>
</div>
@endsection