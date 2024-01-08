{{Form::open(array('url'=>'maintenance-request','method'=>'post', 'enctype' => "multipart/form-data"))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('property_id',__('Property'),array('class'=>'form-label'))}}
            {{Form::select('property_id',$property,null,array('class'=>'form-control hidesearch','id'=>'property_id'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('unit_id',__('Unit'),array('class'=>'form-label'))}}
            <div class="unit_div">
                <select class="form-control hidesearch unit" id="unit_id" name="unit_id">
                    <option value="">{{__('Select Unit')}}</option>
                </select>
            </div>
        </div>
        <div class="form-group  col-md-6 col-lg-6">
            {{Form::label('request_date',__('Request Date'),array('class'=>'form-label'))}}
            {{Form::date('request_date',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('maintainer_id',__('Maintainer'),array('class'=>'form-label'))}}
            {{Form::select('maintainer_id',$maintainers,null,array('class'=>'form-control hidesearch'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('issue_type',__('Issue Type'),array('class'=>'form-label'))}}
            {{Form::select('issue_type',$types,null,array('class'=>'form-control hidesearch'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('status',__('Status'),array('class'=>'form-label'))}}
            {{Form::select('status',$status,null,array('class'=>'form-control hidesearch'))}}
        </div>
        <div class="form-group  col-md-12 col-lg-12">
            {{Form::label('issue_attachment',__('Issue Attachment'),array('class'=>'form-label'))}}
            {{Form::file('issue_attachment',array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-12 col-lg-12">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label'))}}
            {{Form::textarea('notes',null,array('class'=>'form-control','rows'=>3))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary btn-rounded'))}}
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
                    $('.unit').append('<option value="' + key + '">' + value +'</option>');
                });
                $('.hidesearch').select2({
                    minimumResultsForSearch: -1
                });
            },

        });
    });
</script>

