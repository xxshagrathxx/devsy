@extends('layouts.contentNavbarLayout')

@section('title', 'Users')

@section('users-management', 'active open')
@section('users', 'active')

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <h2>{{ transWord('Users') }}</h2>
            <div class="card mb-4">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary text-start">{{ transWord('Show User') }}</h5>
                            <img src="{{ asset('uploads/users/'.$user->avatar) }}" alt="">
                            <br><br>
                            <h6>Name: {{ $user->name }}</h3>
                            <h6>Email: {{ $user->email }}</h3>
                            <h6>Role: {{ $user->role->name }}</h3>
                            
                            <hr>
                            <a href="{{ route('users-users-all') }}" style="width: 200px" class="btn btn-secondary"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ transWord('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@endsection