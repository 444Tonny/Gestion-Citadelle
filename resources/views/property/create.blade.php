@extends('layouts.app')
@section('page-title')
    {{__('Property Create')}}
@endsection
@push('script-page')
    <script src="{{ asset('assets/js/vendors/dropzone/dropzone.js') }}"></script>
    <script>
        var dropzone = new Dropzone('#demo-upload', {
            previewTemplate: document.querySelector('.preview-dropzon').innerHTML,
            parallelUploads: 10,
            thumbnailHeight: 120,
            thumbnailWidth: 120,
            maxFilesize: 10,
            filesizeBase: 1000,
            autoProcessQueue: false,
            thumbnail: function (file, dataUrl) {
                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (var i = 0; i < images.length; i++) {
                        var thumbnailElement = images[i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    setTimeout(function () {
                        file.previewElement.classList.add("dz-image-preview");
                    }, 1);
                }
            }

        });
        $('#property-submit').on('click', function () {
            "use strict";
            $('#property-submit').attr('disabled', true);
            var fd = new FormData();
            var file = document.getElementById('thumbnail').files[0];

            var files = $('#demo-upload').get(0).dropzone.getAcceptedFiles();
            $.each(files, function (key, file) {
                fd.append('property_images[' + key + ']', $('#demo-upload')[0].dropzone
                    .getAcceptedFiles()[key]); // attach dropzone image element
            });
            fd.append('thumbnail', file);
            var other_data = $('#property_form').serializeArray();
            $.each(other_data, function (key, input) {
                fd.append(input.name, input.value);
            });
            $.ajax({
                url: "{{route('property.store')}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: fd,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if (data.status == "success") {
                        $('#property-submit').attr('disabled', true);
                        toastrs(data.status, data.msg, data.status);
                        var url = '{{ route("property.show", ":id") }}';
                        url = url.replace(':id', data.id);
                        setTimeout(() => {
                            window.location.href = url;
                        }, "1000");

                    } else {
                        toastrs('Error', data.msg, 'error');
                        $('#property-submit').attr('disabled', false);
                    }
                },
                error: function (data) {
                    $('#property-submit').attr('disabled', false);
                    if (data.error) {
                        toastrs('Error', data.error, 'error');
                    } else {
                        toastrs('Error', data, 'error');
                    }
                },
            });
        });

    </script>
@endpush
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('property.index')}}">{{__('Property')}}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Create')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    {{Form::open(array('url'=>'property','method'=>'post', 'enctype' => "multipart/form-data","id"=>"property_form"))}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="info-group">
                        <div class="form-group ">
                            {{Form::label('type',__('Type'),array('class'=>'form-label'))}}
                            {{Form::select('type',$types,null,array('class'=>'form-control hidesearch'))}}
                        </div>
                        <div class="form-group">
                            {{Form::label('name',__('Name'),array('class'=>'form-label'))}}
                            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Property Name')))}}
                        </div>
                        <div class="form-group ">
                            {{Form::label('description',__('Description'),array('class'=>'form-label'))}}
                            {{Form::textarea('description',null,array('class'=>'form-control','rows'=>8,'placeholder'=>__('Enter Property Description')))}}
                        </div>
                        <div class="form-group">
                            {{Form::label('thumbnail',__('Thumbnail Image'),array('class'=>'form-label'))}}
                            {{Form::file('thumbnail',array('class'=>'form-control'))}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="info-group">
                        <div class="form-group">
                            {{Form::label('country',__('Country'),array('class'=>'form-label'))}}
                            {{Form::text('country',null,array('class'=>'form-control','placeholder'=>__('Enter Property Country')))}}
                        </div>
                        <div class="form-group">
                            {{Form::label('state',__('State'),array('class'=>'form-label'))}}
                            {{Form::text('state',null,array('class'=>'form-control','placeholder'=>__('Enter Property State')))}}
                        </div>
                        <div class="form-group">
                            {{Form::label('city',__('City'),array('class'=>'form-label'))}}
                            {{Form::text('city',null,array('class'=>'form-control','placeholder'=>__('Enter Property City')))}}
                        </div>
                        <div class="form-group">
                            {{Form::label('zip_code',__('Zip Code'),array('class'=>'form-label'))}}
                            {{Form::text('zip_code',null,array('class'=>'form-control','placeholder'=>__('Enter Property Zip Code')))}}
                        </div>
                        <div class="form-group ">
                            {{Form::label('address',__('Address'),array('class'=>'form-label'))}}
                            {{Form::textarea('address',null,array('class'=>'form-control','rows'=>3,'placeholder'=>__('Enter Property Address')))}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{Form::label('demo-upload',__('Property Images'),array('class'=>'form-label'))}}
                </div>
                <div class="card-body">
                    <div class="dropzone needsclick" id='demo-upload' action="#">
                        <div class="dz-message needsclick">
                            <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
                            <h3>{{__('Drop files here or click to upload.')}}</h3>
                        </div>
                    </div>
                    <div class="preview-dropzon" style="display: none;">
                        <div class="dz-preview dz-file-preview">
                            <div class="dz-image"><img data-dz-thumbnail="" src="" alt=""></div>
                            <div class="dz-details">
                                <div class="dz-size"><span data-dz-size=""></span></div>
                                <div class="dz-filename"><span data-dz-name=""></span></div>
                            </div>
                            <div class="dz-progress"><span class="dz-upload"
                                                           data-dz-uploadprogress="">                    </span></div>
                            <div class="dz-success-mark"><i class="fa fa-check" aria-hidden="true"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="group-button text-end">
                {{Form::submit(__('Create'),array('class'=>'btn btn-primary btn-rounded','id'=>'property-submit'))}}
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection

