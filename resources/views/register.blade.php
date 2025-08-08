@extends('include/auth')

@section('title', 'Register')

@section('customcss')
<link rel="stylesheet" href="{{asset('vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')

 <!-- /Left Text -->
 {{-- <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
      <img src="{{asset('img/illustrations/auth-register-illustration-light.png')}}" class="auth-cover-illustration w-100" alt="auth-illustration" data-app-light-img="illustrations/auth-register-illustration-light.png" data-app-dark-img="illustrations/auth-register-illustration-dark.png" />
      <img src="{{asset('img/illustrations/auth-cover-register-mask-light.png')}}" class="authentication-image" alt="mask" data-app-light-img="illustrations/auth-cover-register-mask-light.png" data-app-dark-img="illustrations/auth-cover-register-mask-dark.png" />
    </div> --}}
    <!-- /Left Text -->

    <!-- Register -->
    <div class="d-flex col-12 col-lg-12 col-xl-12 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
      <div class="w-px-400 mx-auto pt-5 pt-lg-0">
        @if ($errors->any())
          @foreach ($errors->all() as $error)
              <div class="alert alert-danger" role="alert">
                      {{ $error }}
              </div>
          @endforeach
        @endif
        <h4 class="mb-1">Adventure starts here 🚀</h4>
        <p class="mb-5">Make your app management easy and fun!</p>

        <form id="formAuthentication" class="mb-5" action="{{url(route('admin_signup'))}}" method="POST">
        @csrf
          <div class="form-floating form-floating-outline mb-5">
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus>
            <label for="username">Username</label>
          </div>
          <div class="form-floating form-floating-outline mb-5">
            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
            <label for="email">Email</label>
          </div>
          <div class="mb-5 form-password-toggle">
            <div class="input-group input-group-merge">
              <div class="form-floating form-floating-outline">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <label for="password">Password</label>
              </div>
              <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
            </div>
          </div>
          <button class="btn btn-primary d-grid w-100">
            Sign up
          </button>
        </form>

        <p class="text-center">
          <span>Already have an account?</span>
          <a href="{{url(route('admin_login'))}}">
            <span>Sign in instead</span>
          </a>
        </p>
      </div>
    </div>
    <!-- /Register -->       

@endsection

@section('customjs')
{{-- <script src="{{ asset('js/pages-auth.js') }}"></script> --}}
@endsection