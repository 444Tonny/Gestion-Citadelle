{{Form::open(array('url'=>'users','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        @if(\Auth::user()->type == 'super admin')
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('name',__('Name'),array('class'=>'form-label')) }}
                    {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))}}
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
                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter Email'),'required'=>'required'))}}

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('password',__('Password'),array('class'=>'form-label'))}}
                {{Form::password('password',array('class'=>'form-control','placeholder'=>__('Enter Password'),'required'=>'required','minlength'=>"6"))}}

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
                {!! Form::select('role', $roles, null,array('class' => 'form-control hidesearch','required'=>'required')) !!}
            </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary ml-10'))}}
</div>
{{Form::close()}}

