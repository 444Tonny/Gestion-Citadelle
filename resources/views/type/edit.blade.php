{{Form::model($type, array('route' => array('type.update', $type->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="form-group ">
        {{Form::label('title',__('Title'),array('class'=>'form-label'))}}
        {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Invoice / Expense / Maintainance Issue,Type Title')))}}
    </div>
    <div class="form-group">
        {{ Form::label('type', __('Type'),['class'=>'form-label']) }}
        {!! Form::select('type', $types, null,array('class' => 'form-control hidesearch','required'=>'required')) !!}
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
{{ Form::close() }}




