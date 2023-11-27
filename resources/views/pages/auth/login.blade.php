@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          {{-- <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])</span>
              <span class="app-brand-text demo text-body fw-bolder">{{config('variables.templateName')}}</span>
            </a>
          </div> --}}
          <!-- /Logo -->
          {{-- <h4 class="mb-2">Welcome to {{config('variables.templateName')}}! 👋</h4>
          <p class="mb-4">Please sign-in to your account and start the adventure</p> --}}

          <form id="formAuthentication" class="mb-3" action="{{ route('login.check') }}" method="post">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">{{ transWord('Email') }}</label>
              <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="{{ transWord('Enter your email') }}" autofocus>
              @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
              @endif
            </div>
            
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">{{ transWord('Password') }}</label>
                {{-- <a href="{{ route('forgot.password') }}">
                  <small>{{ transWord('Forgot Password?') }}</small>
                </a> --}}
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
              @endif
            </div>
            {{-- <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me">
                <label class="form-check-label" for="remember-me">
                  Remember Me
                </label>
              </div>
            </div> --}}
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">{{ transWord('Sign in') }}</button>
            </div>
          </form>

          {{-- <p class="text-center">
            <span>{{ transWord('New on our platform?') }}</span>
            <a href="{{ route('register-user') }}">
              <span>{{ transWord('Create an account') }}</span>
            </a>
          </p> --}}

          <div class="btn-group col-12 mt-4">
            <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">{{ transWord('Language') }}</button>
            <ul class="dropdown-menu">
              @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li><a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">{{  $properties['native']  }}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection
