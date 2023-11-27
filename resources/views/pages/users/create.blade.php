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
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ transWord('Create User') }}</h5>
                            <form action="{{ route('users-users-store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="col-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ transWord('Name') }}<span class="is-required"> (*)</span></label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ old('name') }}" />
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="form-group">
                                        <label for="email">{{ transWord('Email') }}<span class="is-required"> (*)</span></label>
                                        <input type="email" class="form-control" name="email" placeholder="Enter Email" value="{{ old('email') }}" />
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="form-group">
                                        <label for="password">{{ transWord('Password') }}<span class="is-required"> (*)</span></label>
                                        <input type="password" class="form-control" name="password" placeholder="Enter Password" />
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="form-group">
                                        <label for="password_confirmation">{{ transWord('Confirm Password') }}<span class="is-required"> (*)</span></label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Enter Confirm Password" />
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-6 mb-3">
                                    <div class="form-group">
                                        <label for="role_id">{{ transWord('Role') }}<span class="is-required">(*)</span></label>
                                        <select name="role_id" id="role_id" class="form-select">
                                            <option value="" selected="" disabled="">{{ transWord('Select Role') }}</option>
                                            @foreach ($roles as $role)
                                                @php
                                                    if ($role->id == 1) // To skip assiging a Super Admin
                                                        continue;
                                                @endphp
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="form-group">
                                        <label for="image">{{ transWord('Upload avatar here') }}</label>
                                        <input class="form-control" type="file" name="image">
                                    </div>
                                    <span class="text text-secondary" style="font-size: 11px">{{ transWord('Image is preferred to be 300x300') }}</span>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <hr>
                                <button type="submit" class="btn btn-round btn-success col-md-1 me-2">{{ transWord('Save') }}</button>
                                <a href="{{ route('users-users-all') }}" style="width: 200px" class="btn btn-secondary"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ transWord('Back') }}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@endsection