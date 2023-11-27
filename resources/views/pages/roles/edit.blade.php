@extends('layouts.contentNavbarLayout')

@section('title', 'Roles')

@section('users-management', 'active open')
@section('roles', 'active')

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <h2>{{ transWord('Roles') }}</h2>
            <div class="card mb-4">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ transWord('Edit Roles') }}</h5>
                            <form action="{{ route('users-roles-update', $role->id) }}" method="post">
                                @csrf

                                <div class="col-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ transWord('Role Name') }}<span class="is-required"> (*)</span></label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Role Name" value="{{ old('name', $role->name) }}" />
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr>
                                <button type="submit" class="btn btn-round btn-success col-md-1 me-2">{{ transWord('Save') }}</button>
                                <a href="{{ route('users-roles-all') }}" style="width: 200px" class="btn btn-secondary"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ transWord('Back') }}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@endsection