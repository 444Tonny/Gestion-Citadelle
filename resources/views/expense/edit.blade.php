{{Form::model($expense, array('route' => array('expense.update', $expense->id), 'method' => 'PUT','enctype' => "multipart/form-data")) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12 col-lg-12">
            {{Form::label('title',__('Expense Title'),array('class'=>'form-label'))}}
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Expense Title')))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            <div class="form-group">
                {{Form::label('expense_id',__('Expense Number'),array('class'=>'form-label'))}}
                <div class="input-group">
                    <span class="input-group-text ">
                      {{\App\Models\Custom::expensePrefix()}}
                    </span>
                    {{Form::text('expense_id',null,array('class'=>'form-control','placeholder'=>__('Enter Expense Number')))}}
                </div>
            </div>
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('expense_type',__('Expense Type'),array('class'=>'form-label'))}}
            {{Form::select('expense_type',$types,null,array('class'=>'form-control hidesearch'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('property_id',__('Property'),array('class'=>'form-label'))}}
            {{Form::select('property_id',$property,null,array('class'=>'form-control hidesearch','id'=>'property_id'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('unit_id',__('Unit'),array('class'=>'form-label'))}}
            <input type="hidden" id="edit_unit" value="{{$expense->unit_id}}">
            <div class="unit_div">
                <select class="form-control hidesearch unit" id="unit_id" name="unit_id">
                    <option value="">{{__('Select Unit')}}</option>
                </select>
            </div>
        </div>
        <div class="form-group  col-md-6 col-lg-6">
            {{Form::label('date',__('Date'),array('class'=>'form-label'))}}
            {{Form::date('date',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-6 col-lg-6">
            {{Form::label('amount',__('Amount'),array('class'=>'form-label'))}}
            {{Form::number('amount',null,array('class'=>'form-control','placeholder'=>__('Enter Expense Amount')))}}
        </div>
        <div class="form-group  col-md-12 col-lg-12">
            {{Form::label('receipt',__('Receipt'),array('class'=>'form-label'))}}
            {{Form::file('receipt',array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-12 col-lg-12">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label'))}}
            {{Form::textarea('notes',null,array('class'=>'form-control','rows'=>3))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
{{ Form::close() }}
<script>
    $('#property_id').on('change', function () {
        "use strict";
        var property_id=$(this).val();
        var url = '{{ route("property.unit", ":id") }}';
        url = url.replace(':id', property_id);
        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                property_id:property_id,
            },
            contentType: false,
            processData: false,
            type: 'GET',
            success: function (data) {
                $('.unit').empty();
                var unit = `<select class="form-control hidesearch unit" id="unit_id" name="unit_id"></select>`;
                $('.unit_div').html(unit);

                $.each(data, function(key, value) {
                    var unit_id= $('#edit_unit').val();
                    if(key==unit_id){
                        $('.unit').append('<option selected value="' + key + '">' + value +'</option>');
                    }else{
                        $('.unit').append('<option   value="' + key + '">' + value +'</option>');
                    }
                });
                $('.hidesearch').select2({
                    minimumResultsForSearch: -1
                });
            },

        });
    });

    $('#property_id').trigger('change');
</script>



