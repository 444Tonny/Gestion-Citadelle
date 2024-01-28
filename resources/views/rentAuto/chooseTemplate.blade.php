{{ Form::open(['route' => 'rentAuto.showAutoForm', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('template', 'Email template',['class'=>'form-label']) }}
                {!! Form::select('template', $templates, null,array('class' => 'form-control hidesearch','required'=>'required')) !!}
            </div>  

            <div class="form-group">
                <button class="btn btn-primary" name='submitType' type='submit' value='auto' style='width:100%;height:42px'>Créer un nouveau</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
</div>
{{Form::close()}}

