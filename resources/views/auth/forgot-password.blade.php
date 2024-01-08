@extends('layouts.auth')
@section('tab-title')
    {{__('Reset Password')}}
@endsection
@section('content')
    <div class="codex-authbox">
        <div class="auth-header">
            <div class="codex-brand">
                <a href="#">
                    <img class="img-fluid light-logo" src="{{asset(Storage::url('upload/logo/')).'/logo.png'}}" alt="">
                    <img class="img-fluid dark-logo" src="{{asset(Storage::url('upload/logo/')).'/logo.png'}}" alt="">
                </a>
            </div>
            <h3>{{__('forgot password ?')}}</h3>
            <p>{{__('Enter Your Email And Well Send You A Link To Reset')}} <br> {{__('Your Password.')}}</p>
        </div>
        {{Form::open(array('route'=>'password.email','method'=>'post','id'=>'loginForm'))}}
        <div class="form-group mb-0">
            {{Form::label('email','Email')}}
            {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter your email')))}}
            @error('email')
            <span class="invalid-email text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group mb-0">
            <button class="btn btn-primary" type="submit"><i class="fa fa-key"></i> {{__('Send Reset Link')}}</button>
        </div>
        <div class="auth-footer">
            <h6 class="text-center">{{__('Back to')}} <a class="text-primary" href="{{ route('login') }}">{{__('Log In')}}</a></h6>
        </div>
        {{Form::close()}}
    </div>
@endsection

