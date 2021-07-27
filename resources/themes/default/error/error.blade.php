@extends(AppConfig::themeLayout("layout"))

@section('meta')
    <meta name="description" content="{{ $item->description }}">
@endsection

@section('title')
    {{ Error code {{ $code }} }} - {{ AppConfig::name() }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col my-4">
                <h1 class="text-center ne-h1">
                    Error code {{ $code }}
                </h1>

                <p class="text-center ne-short-description">
                    {{ $message }}
                </p>
            </div>
        </div>
    </div>
@endsection