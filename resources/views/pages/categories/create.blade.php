@extends('layouts.contentNavbarLayout')

@section('title', 'Categories')

@section('categories-management', 'active open')
@section('categories', 'active')

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <h2>{{ transWord('Categories') }}</h2>
            <div class="card mb-4">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ transWord('Create Category') }}</h5>
                            <form action="{{ route('categories-store') }}" method="post">
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

                                <hr>
                                <button type="submit" class="btn btn-round btn-success col-md-1 me-2">{{ transWord('Save') }}</button>
                                <a href="{{ route('categories-all') }}" style="width: 200px" class="btn btn-secondary"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ transWord('Back') }}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@endsection