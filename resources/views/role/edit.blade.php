@extends('layouts.app')
@section('page-title')
    {{__('Role')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('role.index')}}">{{__('Roles')}}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Edit')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    @php
        $modules=\App\Models\Custom::permissionModules();
    @endphp
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{$role->name}} : {{__('Edit Role And Permissions')}}</h4>
                </div>
                <div class="card-body">
                    {{Form::model($role, array('route' => array('role.update', $role->id), 'method' => 'PUT')) }}
                    @if($role->name != 'tenant' && $role->name != 'maintainer')
                    <div class="form-group">
                        <div class="small-group">
                            <div>
                                {{Form::label('name',__('Role Name'),['class'=>'form-label'])}}
                                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter role name')))}}
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(!empty($permissions))
                        @foreach($modules as $module)
                            <div class="custom-card">
                                <div class="card-header">
                                    <h5>{{ucfirst($module)}}</h5>
                                </div>
                                <div class="card-body">
                                    @if(in_array('manage '.$module,(array) $permissions))
                                        @if($key = array_search('manage '.$module,$permissions))
                                            <div class="form-check custom-chek form-check-inline">
                                                {{Form::checkbox('permissions[]',$key,null, ['class'=>'form-check-input','id' =>'permission'.$key])}}
                                                {{Form::label('permission'.$key,'Manage',['class'=>'form-check-label'])}}
                                            </div>
                                        @endif
                                    @endif
                                    @if(in_array('create '.$module,(array) $permissions))
                                        @if($key = array_search('create '.$module,$permissions))
                                            <div class="form-check custom-chek form-check-inline">
                                                {{Form::checkbox('permissions[]',$key,null, ['class'=>'form-check-input','id' =>'permission'.$key])}}
                                                {{Form::label('permission'.$key,'Create',['class'=>'form-check-label'])}}
                                            </div>
                                        @endif
                                    @endif
                                    @if(in_array('edit '.$module,(array) $permissions))
                                        @if($key = array_search('edit '.$module,$permissions))
                                            <div class="form-check custom-chek form-check-inline">
                                                {{Form::checkbox('permissions[]',$key,null, ['class'=>'form-check-input','id' =>'permission'.$key])}}
                                                {{Form::label('permission'.$key,'Edit',['class'=>'form-check-label'])}}
                                            </div>
                                        @endif
                                    @endif
                                    @if(in_array('delete '.$module,(array) $permissions))
                                        @if($key = array_search('delete '.$module,$permissions))
                                            <div class="form-check custom-chek form-check-inline">
                                                {{Form::checkbox('permissions[]',$key,null, ['class'=>'form-check-input','id' =>'permission'.$key])}}
                                                {{Form::label('permission'.$key,'Delete',['class'=>'form-check-label'])}}
                                            </div>
                                        @endif
                                    @endif
                                    @if(in_array('show '.$module,(array) $permissions))
                                        @if($key = array_search('show '.$module,$permissions))
                                            <div class="form-check custom-chek form-check-inline">
                                                {{Form::checkbox('permissions[]',$key,null, ['class'=>'form-check-input','id' =>'permission'.$key])}}
                                                {{Form::label('permission'.$key,'Show',['class'=>'form-check-label'])}}
                                            </div>
                                        @endif
                                    @endif
                                        @if(in_array('reply '.$module,(array) $permissions))
                                            @if($key = array_search('reply '.$module,$permissions))
                                                <div class="form-check custom-chek form-check-inline">
                                                    {{Form::checkbox('permissions[]',$key,null, ['class'=>'form-check-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Reply',['class'=>'form-check-label'])}}
                                                </div>
                                            @endif
                                        @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="form-group mt-20 text-end">
                        {{Form::submit(__('Update'),array('class'=>'btn btn-primary btn-rounded'))}}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

