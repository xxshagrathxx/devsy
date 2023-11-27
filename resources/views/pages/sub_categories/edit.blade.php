@extends('layouts.contentNavbarLayout')

@section('title', 'SubCategories')

@section('sub_categories-management', 'active open')
@section('sub_categories', 'active')

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <h2>{{ transWord('SubCategories') }}</h2>
            <div class="card mb-4">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ transWord('Create SubCategory') }}</h5>
                            <form action="{{ route('sub_categories-update', $subCategory->id) }}" method="post">
                                @csrf

                                <div class="col-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">{{ transWord('Name') }}<span class="is-required"> (*)</span></label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ old('name', $subCategory->name) }}" />
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="form-group">
                                        <label for="category_id">{{ transWord('Category') }}<span class="is-required">(*)</span></label>
                                        <select name="category_id" id="category_id" class="form-select">
                                            <option value="" selected="" disabled="">{{ transWord('Select Category') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $subCategory->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr>
                                <button type="submit" class="btn btn-round btn-success col-md-1 me-2">{{ transWord('Save') }}</button>
                                <a href="{{ route('sub_categories-all') }}" style="width: 200px" class="btn btn-secondary"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ transWord('Back') }}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@endsection