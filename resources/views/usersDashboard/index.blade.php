@extends('layouts.dashboard')

@section('title')
    All users - 
@endsection

@section('pageTitle')
    All users
@endsection

@section('content')
<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Created at</th>
            <th scope="col">Role</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{$loop->index + 1}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->created_at}}</td>
                    <td>
                        @if($user->roles == 'admin')
                            Administrator
                        @elseif($user->roles == 'user')
                            User
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-primary my-2" href="{{route('usersEdit', ['id' => $user->id])}}" style="color:white;text-decoration:none;">
                            Edit
                        </a>

                        <a class="btn btn-primary my-2" href="{{route('usersSubscriptionDetails', ['id' => $user->id])}}" style="color:white;text-decoration:none;">
                            Subscription details
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>   
</div>
{{ $users->links() }}
@endsection
