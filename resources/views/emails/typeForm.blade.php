{{ Form::open(['route' => 'prepareSend', 'method' => 'post']) }}
<style>
    .btn-black
    {
        background: #2c2c2c !important;
        border: 1px #2c2c2c !important; 
    }
</style>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('template', 'Email template',['class'=>'form-label']) }}
                {!! Form::select('template', $templates, null,array('class' => 'form-control hidesearch','required'=>'required')) !!}
            </div>  

            <div class="form-group">
                <button class="btn btn-primary" name='submitType' type='submit' value='single' style='width:100%;height:42px'>Envoi simple</button>
            </div>

            <div class="form-group">
                <button class="btn btn-secondary" name='submitType' type='submit' value='group' style='width:100%;height:42px'>Envoi groupé</button>
            </div>
            
            <div class="form-group">
                <button class="btn btn-secondary btn-black" name='submitType' type='submit' value='auto' style='width:100%;height:42px'>Envoi automatisé</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
</div>
{{Form::close()}}

