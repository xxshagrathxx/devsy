@extends('layouts.contentNavbarLayout')

@section('title', 'Profile')

@section('page-script')
    <script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
@endsection 

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <h2>{{ transWord('My Profile') }}</h2>
            <div class="card mb-4">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ transWord('Edit Profile') }}</h5>
                            <form action="{{ route('profile-update') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="old_img" value="{{ $user->avatar }}">

                                <div class="row">
                                    <div class="col-9">

                                        <div class="col-8 mb-3">
                                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                                <img src="{{asset('uploads/users/'.$user->avatar)}}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                                <div class="form-group">
                                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                        <span class="d-none d-sm-block">{{ transWord('Upload avatar here') }}</span>
                                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                                        <input class="form-control account-file-input" type="file" name="image" id="upload" hidden>
                                                    </label>
                                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">{{ transWord('Reset') }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <span class="text text-secondary" style="font-size: 11px">{{ transWord('Image is preferred to be 300x300') }}</span>
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-8 mb-3">
                                            <div class="form-group">
                                                <label for="name">{{ transWord('Name') }}<span class="is-required"> (*)</span></label>
                                                <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ old('name', $user->name) }}" />
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
        
                                        <div class="col-8 mb-3">
                                            <div class="form-group">
                                                <label for="password">{{ transWord('Password') }}</label>
                                                <input type="password" class="form-control" name="password" placeholder="Enter Password" />
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <span class="text text-secondary" style="font-size: 11px">{{ transWord('Leave it empty if you do not want to change password') }}</span>
                                        </div>
        
                                        <div class="col-8 mb-3">
                                            <div class="form-group">
                                                <label for="password_confirmation">{{ transWord('Confirm Password') }}</label>
                                                <input type="password" class="form-control" name="password_confirmation" placeholder="Enter Confirm Password" />
                                                @error('password_confirmation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
        
                                        {{-- <div class="col-8 mb-3">
                                            <div class="form-group">
                                                <label for="image">{{ transWord('Upload avatar here') }}</label>
                                                <input class="form-control" type="file" name="image">
                                            </div>
                                            <span class="text text-secondary" style="font-size: 11px">{{ transWord('Image is preferred to be 300x300') }}</span>
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div> --}}
                                    </div>

                                    <div class="col-3">
                                        {{-- <img src="{{ asset('uploads/users/'.$user->avatar) }}" style="width: 250px" alt="image" /> --}}
                                    </div>
                                </div>
                                

                                <hr>
                                <button type="submit" class="btn btn-round btn-success col-md-1 me-2">{{ transWord('Save') }}</button>
                                <a href="{{ route('dashboard') }}" style="width: 200px" class="btn btn-secondary"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ transWord('Back') }}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@endsection