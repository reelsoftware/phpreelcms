@extends('layouts.install')

@section('title', 'Database')

@section('content')
<ul class="nav justify-content-center mt-3">
    <li class="nav-item dot done"></li>
    <li class="nav-item dot"></li>
    <li class="nav-item dot"></li>
    <li class="nav-item dot"></li>
</ul>

<div class="container my-3">
    <div class="row">
        <div class="col">
            <p>
                All the boxes should be green. Otherwise, the application might not work properly.            
            </p>

            <div class="card my-2 {{version_compare(PHP_VERSION, '7.2.5', '>=') ? 'alert-success' : 'alert-danger'}}">
                <div class="card-body" id="phpVersion" >
                    <p>PHP {{phpversion()}}</p>
                    <small>Minimum version is 7.2.5</small>
                </div>
            </div>

            <div class="card my-2 {{extension_loaded ('bcmath') ? 'alert-success' : 'alert-danger'}}">
                <div class="card-body" id="phpVersion" >
                    BCMath PHP Extension
                </div>
            </div>

            <div class="card my-2 {{extension_loaded ('ctype') ? 'alert-success' : 'alert-danger'}}">
                <div class="card-body" id="phpVersion" >
                    Ctype PHP Extension
                </div>
            </div>

            <div class="card my-2 {{extension_loaded ('fileinfo') ? 'alert-success' : 'alert-danger'}}">
                <div class="card-body" id="phpVersion" >
                    Fileinfo PHP extension
                </div>
            </div>

            <div class="card my-2 {{extension_loaded ('json') ? 'alert-success' : 'alert-danger'}}">
                <div class="card-body" id="phpVersion" >
                    JSON PHP Extension
                </div>
            </div>

            <div class="card my-2 {{extension_loaded ('mbstring') ? 'alert-success' : 'alert-danger'}}">
                <div class="card-body" id="phpVersion" >
                    Mbstring PHP Extension
                </div>
            </div>

            <div class="card my-2 {{extension_loaded ('openssl') ? 'alert-success' : 'alert-danger'}}">
                <div class="card-body" id="phpVersion" >
                    OpenSSL PHP Extension
                </div>
            </div>

            <div class="card my-2 {{extension_loaded ('PDO') ? 'alert-success' : 'alert-danger'}}">
                <div class="card-body" id="phpVersion" >
                    PDO PHP Extension
                </div>
            </div>

            <div class="card my-2 {{extension_loaded ('tokenizer') ? 'alert-success' : 'alert-danger'}}">
                <div class="card-body" id="phpVersion" >
                    Tokenizer PHP Extension
                </div>
            </div>
            
            <div class="card my-2 {{extension_loaded ('xml') ? 'alert-success' : 'alert-danger'}}">
                <div class="card-body" id="phpVersion" >
                    XML PHP Extension
                </div>
            </div>

            <a href="{{route('installConfig')}}" class="btn btn-primary">Next</a>
        </div>
    </div>
</div>
@endsection
