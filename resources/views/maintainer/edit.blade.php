{{ Form::model($maintainer, array('route' => array('maintainer.update', $maintainer->id), 'method' => 'PUT','enctype' => "multipart/form-data")) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('first_name',__('First Name'),array('class'=>'form-label'))}}
            {{Form::text('first_name',$user->first_name,array('class'=>'form-control','placeholder'=>__('Enter First Name')))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('last_name',__('Last Name'),array('class'=>'form-label'))}}
            {{Form::text('last_name',$user->last_name,array('class'=>'form-control','placeholder'=>__('Enter Last Name')))}}
        </div>
        <div class="form-group col-md-6 col-lg-6 ">
            {{Form::label('email',__('Email'),array('class'=>'form-label'))}}
            {{Form::text('email',$user->email,array('class'=>'form-control','placeholder'=>__('Enter Email')))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('phone_number',__('Phone Number'),array('class'=>'form-label'))}}
            {{Form::text('phone_number',$user->phone_number,array('class'=>'form-control','placeholder'=>__('Enter Phone Number')))}}
        </div>
        <div class="form-group">
            {{Form::label('property_id',__('Property'),array('class'=>'form-label'))}}
            {{Form::select('property_id[]',$property,explode(',',$maintainer->property_id),array('class'=>'form-control hidesearch','id'=>'property','multiple'))}}
        </div>
        <div class="form-group">
            {{Form::label('type_id',__('Type'),array('class'=>'form-label'))}}
            {{Form::select('type_id',$types,null,array('class'=>'form-control hidesearch'))}}
        </div>
        <div class="form-group">
            {{Form::label('profile',__('Profile'),array('class'=>'form-label'))}}
            {{Form::file('profile',array('class'=>'form-control'))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
{{ Form::close() }}
