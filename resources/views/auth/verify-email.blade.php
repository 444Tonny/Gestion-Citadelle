@extends('layouts.auth')
@section('tab-title')
    {{__('Verify')}}
@endsection
@section('content')
    <div class="codex-authbox">
        <div class="auth-header">
            <div class="auth-icon"><i class="fa fa-unlock-alt"></i></div>
            <h3>{{ __('Verify Your Email Address') }}</h3>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif
            <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
        </div>
        <div class="auth-footer">
            <h6 class="text-center"> {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.</h6>
        </div>
    </div>
@endsection
