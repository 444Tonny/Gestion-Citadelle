@extends('layouts.app')
@section('page-title')
    {{__('Property Details')}}
@endsection
@section('page-class')
    product-detail-page
@endsection
@push('script-page')

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
            <a href="#">{{__('Details')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    @can('create unit')
        <div class="row">
            <div class="col-sm-12 text-end">
                <a href="#" class="btn btn-primary btn-sm customModal" data-title="{{__('Add Unit')}}"
                   data-url="{{ route('unit.create',$property->id) }}" data-size="lg"> <i
                        class="ti-plus mr-5"></i>{{__('Add Unit')}}</a>
            </div>
        </div>
    @endcan
    <div class="row mt-10">
        @foreach($units as $unit)
            <div class="col-xl-3 col-md-6 cdx-xxl-50 cdx-xl-50">
                <div class="card contact-card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h4>{{$unit->name}}</h4>
                            </div>
                            @if(Gate::check('edit unit') || Gate::check('delete unit'))
                                <div class="user-setting">
                                    <div class="action-menu">
                                        <div class="action-toggle"><i data-feather="more-vertical"></i></div>
                                        <ul class="action-dropdown">
                                            @can('edit unit')
                                                <li>
                                                    <a class="customModal" href="#"
                                                       data-url="{{ route('unit.edit',[$property->id,$unit->id]) }}"
                                                       data-title="{{__('Edit Unit')}}" data-size="lg"> <i
                                                            data-feather="edit"> </i>{{__('Edit Unit')}}</a>
                                                </li>
                                            @endcan
                                            @can('delete unit')
                                                <li>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['unit.destroy', $property->id,$unit->id],'id'=>'unit-'.$unit->id]) !!}
                                                    <a href="#" class="confirm_dialog"> <i
                                                            data-feather="trash"></i>{{__('Delete Unit')}}</a>
                                                    {!! Form::close() !!}

                                                </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="user-detail">
                            <ul class="info-list">
                                <li><span>{{__('Bedroom')}} :- </span>{{$unit->bedroom}} </li>
                                <li><span>{{__('Kitchen')}} :- </span>{{$unit->kitchen}}</li>
                                <li><span>{{__('Bath')}} :- </span>{{$unit->baths}}</li>
                                <li><span>{{__('Rent Type')}} :- </span>{{$unit->rent_type}}</li>
                                <li><span>{{__('Rent')}} :- </span>{{\Auth::user()->priceFormat($unit->rent)}}</li>
                                @if($unit->rent_type=='custom')
                                    <li>
                                        <span>{{__('Start Date')}} :- </span>{{\Auth::user()->dateFormat($unit->start_date)}}
                                    </li>
                                    <li>
                                        <span>{{__('End Date')}} :- </span>{{\Auth::user()->dateFormat($unit->end_date)}}
                                    </li>
                                    <li>
                                        <span>{{__('Payment Due Date')}} :- </span>{{\Auth::user()->dateFormat($unit->payment_due_date) }}
                                    </li>
                                @else
                                    <li><span>{{__('Rent Duration')}} :- </span>{{$unit->rent_duration}}</li>
                                @endif
                                <li><span>{{__('Deposit Type')}} :- </span>{{$unit->deposit_type}}</li>
                                <li>
                                    <span>{{__('Deposit Amount')}} :- </span>{{ ($unit->deposit_type=='fixed')?\Auth::user()->priceFormat($unit->deposit_amount):$unit->deposit_amount.'%'}}
                                </li>
                                <li><span>{{__('Late Fee Type')}} :- </span>{{$unit->late_fee_type}}</li>
                                <li>
                                    <span>{{__('Late Fee Amount')}} :- </span>{{ ($unit->deposit_type=='fixed')?\Auth::user()->priceFormat($unit->late_fee_amount):$unit->late_fee_amount.'%'}}
                                </li>
                                <li>
                                    <span>{{__('Incident Receipt Amount')}} :- </span>{{\Auth::user()->priceFormat($unit->incident_receipt_amount)}}
                                </li>
                            </ul>
                            <div class="user-action">
                                <p class="text-light">{{$unit->notes}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-5 cdx-xl-45">
            <div class="product-card">
                <div class="product-for">
                    @foreach($property->propertyImages as $image)
                        @if(!empty($image) && !empty($image->image))
                            @php  $img= $image->image; @endphp
                        @else
                            @php  $img= 'default.jpg'; @endphp
                        @endif
                        <div>
                            <div class="product-imgwrap">
                                <img class="img-fluid" src="{{asset(Storage::url('upload/property')).'/'.$img}}" alt="">
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="product-to">
                    @foreach($property->propertyImages as $image)
                        @if(!empty($image) && !empty($image->image))
                            @php  $img= $image->image; @endphp
                        @else
                            @php  $img= 'default.jpg'; @endphp
                        @endif
                        <div>
                            <div class="product-imgwrap">
                                <img class="img-fluid" src="{{asset(Storage::url('upload/property')).'/'.$img}}" alt="">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-7 cdx-xl-55 cdxpro-detail">
            <div class="product-card">
                <div class="detail-group">
                    <div class="media">
                        <div>
                            <h2>{{$property->name}}</h2>
                            <h6 class="text-light">
                                <div class="date-info">
                                    <span class="badge badge-primary" data-bs-toggle="tooltip"
                                          data-bs-original-title="{{__('Type')}}">{{\App\Models\Property::$Type[$property->type]}}</span>
                                </div>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="detail-group">
                    <h6>{{__('Property Details')}}</h6>
                    <p class="mb-10">{{$property->description}}</p>

                </div>
                <div class="detail-group">
                    <h6>{{__('Property Address')}}</h6>
                    <p class="mb-10">{{$property->address}}</p>
                    <p class="mb-10">{{$property->city.', '.$property->state.', '.$property->country}}</p>
                    <p class="mb-10">{{$property->zip_code}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

