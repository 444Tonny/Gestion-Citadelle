{{Form::open(array('url'=>'support','method'=>'post', 'enctype' => "multipart/form-data"))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{Form::label('subject',__('Subject'),array('class'=>'form-label'))}}
            {{Form::text('subject',null,array('class'=>'form-control','placeholder'=>__('Enter support subject')))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('assign_user',__('Assign'),array('class'=>'form-label'))}}
            {{Form::select('assign_user',$users,null,array('class'=>'form-control hidesearch'))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('attachment',__('Attachment'),array('class'=>'form-label'))}}
            {{Form::file('attachment',array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('priority',__('Priority'),array('class'=>'form-label'))}}
            {{Form::select('priority',$priority,null,array('class'=>'form-control hidesearch'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('status',__('Status'),array('class'=>'form-label'))}}
            {{Form::select('status',$status,null,array('class'=>'form-control hidesearch'))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('description',__('Description'),array('class'=>'form-label'))}}
            {{Form::textarea('description',null,array('class'=>'form-control','rows'=>5))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
{{ Form::close() }}


