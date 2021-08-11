@extends(AppConfig::themeLayout("layout"))

@section('title')
    Subscribe - {{ AppConfig::name() }}
@endsection

@section('content')
    <div class="jumbotron jumbotron-fluid ne-jumbotron-subscribe ne-jumbotron-animation ne-margin-top-under-nav-gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="ne-h1 text-center">
                        {{ __('Subscribe') }}
                    </h2>

                    <p class="ne-short-description text-center" style="font-size:18px">
                        {{ __('Choose one of the available plans') }}
                    </p>
                </div>
            </div> 
        </div>
    </div>

    <div class="container">
        <div class="row">
            @foreach ($plans as $plan)
            <div 
                @if(count($plans) >= 3)
                    class="col-xl-4 col-md-6 col-sm-12"
                @elseif(count($plans) == 2)
                    class="col-md-6 col-sm-12"
                @else
                    class="col-sm-12"
                @endif
            >
                <div class="card ne-card text-center ne-card-pricing">
                    <div class="card-header ne-card-head">
                        {{ $plan->billing_interval == 'day' ? __('Daily') : '' }}
                        {{ $plan->billing_interval == 'week' ? __('Weekly') : '' }}
                        {{ $plan->billing_interval == 'month' ? __('Monthly') : '' }}
                        {{ $plan->billing_interval == 'year' ? __('Yearly') : '' }}
                    </div>

                    <div class="card-body">
                        <h5 class="card-title ne-title">{{ $plan->name }}</h5>
                        <h6 class="card-title ne-title">{{ Utilities::price($plan->price) }} {{ $plan->currency }}</h6>
                        <p class="ne-short-description text-center">{{ $plan->description }}</p>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        @foreach ($benefits[$loop->index] as $benefit)
                            <li class="list-group-item ne-list-item">{{ $benefit }}</li>
                        @endforeach
                    </ul>
                    
                    <div class="card-footer ne-card-footer">
                        @guest
                            <p class="text-center">
                                <a href="{{ UrlRoutes::register() }}" class="btn ne-btn text-center">
                                    {{ __('Sign up') }}
                                </a>
                            </p>
                        @endguest

                        @auth
                            @if($subscription == false)
                                <form action="{{ UrlRoutes::subscribeStorePost() }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $plan->stripe_price_id }}" name="plan">

                                    <input type="submit" class="btn ne-btn" value="Subscribe">
                                </form>
                            @else
                                <p class="ne-short-description" style='font-weight:bold'>
                                    {{ __('Already subscribed') }}
                                </p>
                            @endif
                        @endauth
                    </div> 
                </div>
            </div>   
            @endforeach
        </div>
    </div>
@endsection
