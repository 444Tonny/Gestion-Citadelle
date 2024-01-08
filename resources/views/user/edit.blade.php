{{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        @if(\Auth::user()->type == 'super admin')
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('name',__('Name'),array('class'=>'form-label')) }}
                    {{Form::text('name',$user->first_name,array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))}}
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('first_name',__('First Name'),array('class'=>'form-label')) }}
                    {{Form::text('first_name',null,array('class'=>'form-control','placeholder'=>__('Enter First Name'),'required'=>'required'))}}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('last_name',__('Last Name'),array('class'=>'form-label')) }}
                    {{Form::text('last_name',null,array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))}}
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('email',__('Email'),array('class'=>'form-label'))}}
                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))}}
            </div>
        </div>

        @if(\Auth::user()->type != 'super admin')
                <div class="col-md-12">
                    <div class="form-group">
                        {{Form::label('phone_number',__('Phone Number'),array('class'=>'form-label')) }}
                        {{Form::text('phone_number',null,array('class'=>'form-control','placeholder'=>__('Enter Phone Number'),'required'=>'required'))}}
                    </div>
                </div>
            <div class="form-group col-md-12">
                {{ Form::label('role', __('User Role'),['class'=>'form-label']) }}
                {!! Form::select('role', $roles, null,array('class' => 'form-control hidesearch ','required'=>'required')) !!}
            </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
{{ Form::close() }}
