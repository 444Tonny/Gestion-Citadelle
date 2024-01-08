{{Form::model($role,array('route' => array('assign.permission', $role->id), 'method' => 'post')) }}
@if(!empty($permissions))

    <table class="table table-striped mb-0">
        <tbody>
        @php
            $modules=['user','role','applied job','applicant','interview schedule','archive applicant','hire applicant','custom question','stage','location','job category','type','skill'];
        @endphp
        @foreach($modules as $module)
            <tr>

                <td>
                    <div class="row ">
                        @if(in_array('manage '.$module,(array) $permissions))
                            @if($key = array_search('manage '.$module,$permissions))
                                <div class="col-md-3 custom-control custom-checkbox">
                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                    {{Form::label('permission'.$key,'Manage'.' '. ucfirst($module),['class'=>'custom-control-label'])}}<br>
                                </div>
                            @endif
                        @endif
                        @if(in_array('create '.$module,(array) $permissions))
                            @if($key = array_search('create '.$module,$permissions))
                                <div class="col-md-3 custom-control custom-checkbox">
                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                    {{Form::label('permission'.$key,'Create'.' '. ucfirst($module),['class'=>'custom-control-label'])}}<br>
                                </div>
                            @endif
                        @endif
                        @if(in_array('edit '.$module,(array) $permissions))
                            @if($key = array_search('edit '.$module,$permissions))
                                <div class="col-md-3 custom-control custom-checkbox">
                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                    {{Form::label('permission'.$key,'Edit'.' '. ucfirst($module),['class'=>'custom-control-label'])}}<br>
                                </div>
                            @endif
                        @endif
                        @if(in_array('delete '.$module,(array) $permissions))
                            @if($key = array_search('delete '.$module,$permissions))
                                <div class="col-md-3 custom-control custom-checkbox">
                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                    {{Form::label('permission'.$key,'Delete'.' '. ucfirst($module),['class'=>'custom-control-label'])}}<br>
                                </div>
                            @endif
                        @endif
                        @if(in_array('show '.$module,(array) $permissions))
                            @if($key = array_search('show '.$module,$permissions))
                                <div class="col-md-3 custom-control custom-checkbox">
                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                    {{Form::label('permission'.$key,'Show'.' '. ucfirst($module),['class'=>'custom-control-label'])}}<br>
                                </div>
                            @endif
                        @endif
                        @if(in_array('move '.$module,(array) $permissions))
                            @if($key = array_search('move '.$module,$permissions))
                                <div class="col-md-3 custom-control custom-checkbox">
                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                    {{Form::label('permission'.$key,'Move'.' '. ucfirst($module),['class'=>'custom-control-label'])}}<br>
                                </div>
                            @endif
                        @endif

                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="col-md-12 mt-3">
        {{Form::submit(__('Assign'),array('class'=>'btn btn-primary btn-rounded'))}}
    </div>
@endif
{{ Form::close() }}
