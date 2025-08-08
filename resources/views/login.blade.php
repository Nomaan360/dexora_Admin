@extends('include/auth')

@section('title', 'Login')

@section('customcss')
<link rel="stylesheet" href="{{asset('vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')

       
        <!-- /Left Section -->
        {{-- <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
            <img src="{{asset('img/illustrations/auth-login-illustration-light.png')}}" class="auth-cover-illustration w-100" alt="auth-illustration" data-app-light-img="illustrations/auth-login-illustration-light.png" data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
            <img src="{{asset('img/illustrations/auth-cover-login-mask-light.png')}}" class="authentication-image" alt="mask" data-app-light-img="illustrations/auth-cover-login-mask-light.png" data-app-dark-img="illustrations/auth-cover-login-mask-dark.png" />
            </div> --}}
            <!-- /Left Section -->

            <!-- Login -->
            <div class="card p-md-7 p-1">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                    <a href="{{url('/')}}" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('assets/images/logo.png') }}" height="40">
                        </span>
                    </a>
                </div>
                <div class="card-body mt-1">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    @if ($sessionData = Session::get('data'))
                        @if($sessionData['status_code'] == 1)
                        <div class="alert alert-success" role="alert">{{ $sessionData['message'] }}</div>
                        @else
                        <div class="alert alert-danger" role="alert">{{ $sessionData['message'] }}</div>
                        @endif
                    @endif
                    <h4 class="mb-1">Welcome to Dexora!👋</h4>
                    <p class="mb-5">Please sign-in to your account and start the adventure</p>

                    <form id="formAuthentication" class="mb-0" action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" autofocus>
                            <label for="email">Email</label>
                        </div>
                        <div class="mb-5">
                            <div class="form-password-toggle">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                <label for="password">Password</label>
                                </div>
                                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                            </div>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100">
                            Sign in
                        </button>
                    </form>
                </div>
            </div>
            <!-- /Login -->
@endsection

@section('customjs')
{{-- <script src="{{ asset('js/pages-auth.js') }}"></script> --}}
@endsection