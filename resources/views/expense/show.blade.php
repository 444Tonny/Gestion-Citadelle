<div class="modal-body">
    <div class="product-card">
        <div class="row">
            <div class="col-12">
                <div class="detail-group">
                    <h6>{{__('Expense Title')}}</h6>
                    <p class="mb-20">{{$expense->title}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Expense Number')}}</h6>
                    <p class="mb-20">{{\App\Models\Custom::expensePrefix().$expense->expense_id}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Expense Type')}}</h6>
                    <p class="mb-20">{{!empty($expense->types)?$expense->types->title:'-'}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Property')}}</h6>
                    <p class="mb-20"> {{!empty($expense->properties)?$expense->properties->name:'-'}} </p>
                </div>
            </div>
            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Unit')}}</h6>
                    <p class="mb-20">{{!empty($expense->units)?$expense->units->name:'-'}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Date')}}</h6>
                    <p class="mb-20"> {{\Auth::user()->dateFormat($expense->date)}} </p>
                </div>
            </div>
            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Amount')}}</h6>
                    <p class="mb-20">{{\Auth::user()->priceFormat($expense->amount)}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="detail-group">
                    <h6>{{__('Receipt')}}</h6>
                    <p class="mb-20">
                        @if(!empty($expense->receipt))
                            <a href="{{asset(Storage::url('upload/receipt')).'/'.$expense->receipt}}" download="download"><i data-feather="download"></i></a>
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="detail-group">
                    <h6>{{__('Notes')}}</h6>
                    <p class="mb-20">{{$expense->notes}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
