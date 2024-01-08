@extends('layouts.auth')
@section('tab-title')
    {{__('Login')}}
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
            <h3>{{__('Welcome to')}} {{env('APP_NAME')}}</h3>

        </div>
        {{Form::open(array('route'=>'login','method'=>'post','id'=>'loginForm','class'=> 'login-form' ))}}
            <div class="form-group">
                {{Form::label('email','Email',array('class'=>'form-label'))}}
                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter Your Email')))}}
                @error('email')
                    <span class="invalid-email text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>
            <div class="form-group">
                <label class="form-label" for="Password">{{__('Password')}}</label>
                <div class="input-group group-input">
                    <input class="form-control showhide-password" type="password" name="password" id="Password" placeholder="Enter Your Password" required="">
                    <span class="input-group-text toggle-show fa fa-eye"></span>
                </div>
                @error('password')
                    <span class="invalid-password text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-0">
                <div class="auth-remember">
                    <div class="form-check custom-chek">
                        <input class="form-check-input" id="agree" type="checkbox" value="" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="agree">{{__('Remember me')}}</label>
                    </div>
                    @if (Route::has('password.request'))
                    <a class="text-primary f-pwd" href="{{ route('password.request') }}">{{__('Forgot your password?')}}</a>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit"><i class="fa fa-sign-in"></i> {{__('Login')}}</button>
            </div>
        {{Form::close()}}
        <div class="auth-footer">

            <h6 class="text-center">{{__('Dont have an account?')}} <a class="text-primary" href="{{ route('register') }}">Creat an account</a></h6>
        </div>
    </div>
@endsection
