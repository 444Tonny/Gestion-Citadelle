{{Form::model($permission, array('route' => array('permission.update', $permission->id), 'method' => 'PUT')) }}
<div class="modal-body">
<div class="row">
    <div class="form-group  col-md-12">
        {{Form::label('name',__('Name'))}}
        {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Permission Name')))}}
    </div>
    <div class="col-md-12">
        {{Form::submit(__('Update'),array('class'=>'btn btn-primary btn-rounded'))}}
        <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">{{__('Cancel')}}</button>
    </div>
</div>
</div>
{{ Form::close() }}

