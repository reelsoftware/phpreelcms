@extends('layouts.dashboard')

@section('title')
    All subscription plans - 
@endsection

@section('pageTitle')
    All subscription plans
@endsection

@section('content')
<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Benefits</th>
            <th scope="col">State</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subscriptionPlans as $subscriptionPlan)
                <tr>
                    <th scope="row">{{$loop->index + 1}}</th>
                    <td>{{$subscriptionPlan->name}}</td>
                    <td>{{$subscriptionPlan->description}}</td>
                    <td>{{$subscriptionPlan->benefits}}</td>
                    <td>{{$subscriptionPlan->public ? 'Public' : 'Private'}}</td>
                    <td>
                        <a class="btn btn-primary my-2" href="{{route('subscriptionPlanEdit', ['id' => $subscriptionPlan->id])}}">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>   
</div>
{{ $subscriptionPlans->links() }}

@endsection
