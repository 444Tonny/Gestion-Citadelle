@extends('layouts.app')
@section('page-title')
    {{__('Email Settings')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Email Settings')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{Form::model($loginUser, array('route' => array('setting.smtp'), 'method' => 'post')) }}
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{Form::label('server_driver',__('Email Server Driver'),array('class'=>'form-label')) }}
                            {{Form::text('server_driver',env('SERVER_DRIVER'),array('class'=>'form-control','placeholder'=>__('Enter email server host')))}}
                        </div>
                        <div class="form-group col-md-6">
                            {{Form::label('server_host',__('Email Server Host'),array('class'=>'form-label')) }}
                            {{Form::text('server_host',env('SERVER_HOST'),array('class'=>'form-control ','placeholder'=>__('Enter email server driver')))}}

                        </div>
                        <div class="form-group col-md-6">
                            {{Form::label('server_port',__('Email Server Port'),array('class'=>'form-label')) }}
                            {{Form::text('server_port',env('SERVER_PORT'),array('class'=>'form-control','placeholder'=>__('Enter email server port')))}}

                        </div>
                        <div class="form-group col-md-6">
                            {{Form::label('server_username',__('Email Server Username'),array('class'=>'form-label')) }}
                            {{Form::text('server_username',env('SERVER_USERNAME'),array('class'=>'form-control','placeholder'=>__('Enter email server username')))}}

                        </div>
                        <div class="form-group col-md-6">
                            {{Form::label('server_password',__('Email Server Password'),array('class'=>'form-label')) }}
                            {{Form::text('server_password',env('SERVER_PASSWORD'),array('class'=>'form-control','placeholder'=>__('Enter email server password')))}}

                        </div>
                        <div class="form-group col-md-6">
                            {{Form::label('server_encryption',__('Email Server Encryption'),array('class'=>'form-label')) }}
                            {{Form::text('server_encryption',env('SERVER_ENCRYPTION'),array('class'=>'form-control','placeholder'=>__('Enter email server encryption')))}}

                        </div>
                        <div class="form-group col-md-6">
                            {{Form::label('from_email',__('From Email'),array('class'=>'form-label')) }}
                            {{Form::text('from_email',env('FROM_EMAIL'),array('class'=>'form-control','placeholder'=>__('Enter from email')))}}

                        </div>
                        <div class="form-group col-md-6">
                            {{Form::label('from_name',__('From Name'),array('class'=>'form-label')) }}
                            {{Form::text('from_name',env('FROM_NAME'),array('class'=>'form-control','placeholder'=>__('Enter from name')))}}

                        </div>
                    </div>
                    <div class="text-right">
                        {{Form::submit(__('Save'),array('class'=>'btn btn-primary btn-rounded'))}}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

