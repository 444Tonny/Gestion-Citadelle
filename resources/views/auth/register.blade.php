@extends('layouts.auth')
@section('tab-title')
    {{__('Register')}}
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
            <h3>{{__('Create your account')}}</h3>

        </div>
        {{Form::open(array('route'=>'register','method'=>'post','id'=>'loginForm'))}}
        <div class="form-group ">
            {{Form::label('name','Name',array('class'=>'form-label'))}}
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Your Name')))}}
            @error('name')
            <span class="invalid-name text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group ">
            {{Form::label('email','Email',array('class'=>'form-label'))}}
            {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter Your Email')))}}
            @error('email')
            <span class="invalid-email text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            {{Form::label('password','Password',array('class'=>'form-label'))}}
            <div class="input-group group-input">
                <input class="form-control showhide-password" type="password" name="password" id="Password"
                       placeholder="{{__('Enter Your Password')}}" required="">
                <span class="input-group-text toggle-show fa fa-eye"></span>
            </div>
        </div>
        <div class="form-group">
            {{Form::label('password_confirmation','Password Confirmation',array('class'=>'form-label'))}}
            <div class="input-group group-input">
                <input class="form-control showhide-password" type="password" name="password_confirmation" id="password_confirmation"
                       placeholder="{{__('Enter Your Confirm Password')}}" required="">
                <span class="input-group-text toggle-show fa fa-eye"></span>
            </div>
        </div>
        <div class="form-group mb-0">
            <div class="auth-remember">
                <div class="form-check custom-chek">
                    <input class="form-check-input" id="agree" type="checkbox" value="" required="">
                    <label class="form-check-label" for="agree">{{__('I Agree Terms and conditions')}}</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> {{__('Register')}}</button>
        </div>
        {{Form::close()}}
        <div class="auth-footer">
            <h6 class="text-center">{{__('Already have an account?')}} <a class="text-primary" href="{{ route('login') }}">{{__('Login in here')}}</a></h6>
        </div>
    </div>
@endsection
