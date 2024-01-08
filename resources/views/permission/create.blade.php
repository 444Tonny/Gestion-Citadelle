{{ Form::open(array('url' => 'permission')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{Form::label('name',__('Name'))}}
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Permission Name')))}}
        </div>
        <div class="form-group  col-md-12">
            @if(!$roles->isEmpty())
                <h6>{{__('Role')}}</h6>
                @foreach ($roles as $role)
                    <div class="custom-control custom-checkbox">
                        {{Form::checkbox('roles[]',$role->id,false, ['class'=>'custom-control-input','id' =>'role'.$role->id])}}
                        {{Form::label('role'.$role->id, __(ucfirst($role->name)),['class'=>'custom-control-label '])}}
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-md-12">
            {{Form::submit(__('Create'),array('class'=>'btn btn-primary btn-rounded'))}}
            <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">{{__('Cancel')}}</button>
        </div>
    </div>
</div>
{{ Form::close() }}


