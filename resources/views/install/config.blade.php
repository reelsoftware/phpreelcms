@extends('layouts.install')

@section('title', 'Configure')

@section('content')
<ul class="nav nav-dots justify-content-center">
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot"></li>
    <li class="nav-item dot"></li>
</ul>

<div class="container">
    <div class="row">
        <div class="col my-2">
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
                                        <input type="text" class="form-control" name="{{$env}}">

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