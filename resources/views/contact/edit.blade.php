{{Form::model($contact, array('route' => array('contact.update', $contact->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{Form::label('name',__('Name'))}}
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter contact name')))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('email',__('Email'))}}
            {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter contact email')))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('contact_number',__('Contact Number'))}}
            {{Form::number('contact_number',null,array('class'=>'form-control','placeholder'=>__('Enter contact number')))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('subject',__('Subject'))}}
            {{Form::text('subject',null,array('class'=>'form-control','placeholder'=>__('Enter contact subject')))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('message',__('Message'))}}
            {{Form::textarea('message',null,array('class'=>'form-control','rows'=>5))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
{{ Form::close() }}

