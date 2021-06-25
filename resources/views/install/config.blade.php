@extends('layouts.install')

@section('title', 'Configure')

@section('content')
<ul class="nav justify-content-center">
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot done"></li>
    <li class="nav-item dot"></li>
    <li class="nav-item dot"></li>
</ul>

<div class="container">
    <div class="row">
        <div class="col my-2">
            <form method="POST" action="{{route('storeDatabase')}}">
                @csrf
                <!--List env config fields-->
                <div class="accordion" id="accordionExample">
                    @foreach ($envFields as $section => $envField)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#{{ str_replace(" ", "_", $section) }}" aria-expanded="true" aria-controls="collapseOne">
                                    {{ $section }}
                                </button>
                            </h2>

                            @foreach ($envField as $env)
                                <div id="{{ str_replace(" ", "_", $section) }}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group">
                                            <label for="hostname">{{$env}}</label>
                                            <input type="text" class="form-control" name="{{$env}}">

                                            @error('{{$env}}')
                                                <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                
                <button type="submit" class="btn btn-primary">Next</button>
            </form>
        </div>
    </div>
</div>
@endsection