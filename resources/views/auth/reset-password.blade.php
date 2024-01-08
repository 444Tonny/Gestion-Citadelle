@extends('layouts.auth')
@section('tab-title')
    {{__('Reset Password')}}
@endsection
@section('content')
    <div class="codex-authbox">
        <div class="auth-header">
            <div class="auth-icon"><i class="fa fa-unlock-alt"></i></div>
            <h3>{{__('Reset your password')}}</h3>
            <p>{{__('You have Successfully Verified Your Account. Enter')}} <br> {{__('New Passeord Below.')}}</p>
        </div>
        {{Form::open(array('route'=>'password.update','method'=>'post','id'=>'loginForm'))}}
            <div class="form-group">
                {{Form::label('email',__('Email Address'),array('class'=>'form-label'))}}
                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter Your Email')))}}
                @error('email')
                <span class="invalid-email text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password">{{__('New Password')}}</label>
                <div class="input-group group-input">
                    <input class="form-control showhide-password" type="password" id="password" name="password" placeholder="{{__('Enter Your New Password')}}" required="">
                    <span class="input-group-text toggle-show fa fa-eye"></span>
                </div>
                @error('password')
                <span class="invalid-password text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            </div>
            <div class="form-group">
                <label class="form-label" for="newpassword">{{__('Confirm Password')}}</label>
                <div class="input-group group-input">
                    <input class="form-control showhide-password" type="password" id="newpassword" name="password_confirmation" placeholder="Re Enter Your Password" required="">
                    <span class="input-group-text toggle-show fa fa-eye"></span>
                </div>
                @error('password_confirmation')
                <span class="invalid-password_confirmation text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group mb-0">
                <button class="btn btn-primary" type="submit">{{__('Update Password')}}</button>
            </div>
        {{Form::close()}}
    </div>
    </div>
@endsection
