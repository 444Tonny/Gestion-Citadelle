<div class="modal-body">
    <div class="product-card">
        <div class="row">
            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Property')}}</h6>
                    <p class="mb-20"> {{!empty($maintenanceRequest->properties)?$maintenanceRequest->properties->name:'-'}} </p>
                </div>
            </div>
            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Unit')}}</h6>
                    <p class="mb-20">{{!empty($maintenanceRequest->units)?$maintenanceRequest->units->name:'-'}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Issue')}}</h6>
                    <p class="mb-20">{{!empty($maintenanceRequest->types)?$maintenanceRequest->types->title:'-'}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Maintainer')}}</h6>
                    <p class="mb-20"> {{!empty($maintenanceRequest->maintainers)?$maintenanceRequest->maintainers->name:'-'}} </p>
                </div>
            </div>

            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Request Date')}}</h6>
                    <p class="mb-20">{{\Auth::user()->dateFormat($maintenanceRequest->request_date)}}  </p>
                </div>
            </div>
            @if(!empty($maintenanceRequest->fixed_date))
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Fixed Date')}}</h6>
                        <p class="mb-20"> {{\Auth::user()->dateFormat($maintenanceRequest->fixed_date)}} </p>
                    </div>
                </div>
            @endif
            @if($maintenanceRequest->amount!=0)
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Amount')}}</h6>
                        <p class="mb-20"> {{\Auth::user()->priceFormat($maintenanceRequest->amount)}} </p>
                    </div>
                </div>
            @endif
            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Status')}}</h6>
                    <p class="mb-20">
                        @if($maintenanceRequest->status=='pending')
                            <span
                                class="badge badge-warning"> {{\App\Models\MaintenanceRequest::$status[$maintenanceRequest->status]}}</span>
                        @elseif($maintenanceRequest->status=='in_progress')
                            <span
                                class="badge badge-info"> {{\App\Models\MaintenanceRequest::$status[$maintenanceRequest->status]}}</span>
                        @else
                            <span
                                class="badge badge-primary"> {{\App\Models\MaintenanceRequest::$status[$maintenanceRequest->status]}}</span>
                        @endif
                    </p>
                </div>
            </div>

            @if(!empty($maintenanceRequest->invoice))
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Invoice')}}</h6>
                        <p class="mb-20">
                            <a href="{{asset(Storage::url('upload/invoice')).'/'.$maintenanceRequest->invoice}}"
                               download="download"><i data-feather="download"></i></a>
                        </p>
                    </div>
                </div>
            @endif

            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Attachment')}}</h6>
                    <p class="mb-20">
                        @if(!empty($maintenanceRequest->issue_attachment))
                            <a href="{{asset(Storage::url('upload/issue_attachment')).'/'.$maintenanceRequest->receipt}}"
                               download="download"><i data-feather="download"></i></a>
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="detail-group">
                    <h6>{{__('Notes')}}</h6>
                    <p class="mb-20">{{$maintenanceRequest->notes}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
