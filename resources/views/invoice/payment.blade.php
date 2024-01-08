{{Form::open(array('route'=>array('invoice.payment.store',$invoice_id),'method'=>'post','enctype' => "multipart/form-data"))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{Form::label('payment_date',__('Payment Date'),array('class'=>'form-label'))}}
            {{Form::date('payment_date',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('amount',__('Amount'),array('class'=>'form-label'))}}
            {{Form::number('amount',$invoice->getDue(),array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('receipt',__('Receipt'),array('class'=>'form-label'))}}
            {{Form::file('receipt',array('class'=>'form-control'))}}
        </div>
        <div class="form-group ">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label'))}}
            {{Form::textarea('notes',null,array('class'=>'form-control','rows'=>3,'placeholder'=>__('Enter Payment Notes')))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Add'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
{{ Form::close() }}


