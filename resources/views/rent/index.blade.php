@extends('layouts.app')
@section('page-title')
    {{__('Rent')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Rent')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @can('create invoice')
        <a class="btn btn-primary btn-sm ml-20" href="{{ route('rent.create') }}"> <i
                class="ti-plus mr-5"></i>{{__('Create Invoice')}}</a>
    @endcan
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th>{{__('Invoice')}}</th>
                            <th>{{__('Property')}}</th>
                            <th>{{__('Unit')}}</th>
                            <th>{{__('Invoice Month')}}</th>
                            <th>{{__('End Date')}}</th>
                            <th>{{__('Amount')}}</th>
                            <th>{{__('Status')}}</th>
                            @if(Gate::check('edit invoice') || Gate::check('delete invoice') || Gate::check('show invoice'))
                                <th class="text-right">{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                            <tr role="row">
                                <td>{{\App\Models\Custom::invoicePrefix().$invoice->invoice_id}} </td>
                                <td>{{!empty($invoice->properties)?$invoice->properties->name:'-'}} </td>
                                <td>{{!empty($invoice->units)?$invoice->units->name:'-'}}  </td>
                                <td>{{date('F Y',strtotime($invoice->invoice_month))}} </td>
                                <td>{{\Auth::user()->dateFormat($invoice->end_date)}} </td>
                                <td>{{\Auth::user()->priceFormat($invoice->getSubTotal())}}</td>
                                <td>
                                    @if($invoice->status=='ouvert')
                                        <span
                                            class="badge badge-primary">Non-payé</span>
                                    @elseif($invoice->status=='complet')
                                        <span
                                            class="badge badge-success">Payé</span>
                                    @elseif($invoice->status=='partiel')
                                        <span
                                            class="badge badge-warning">{{\App\Models\Invoice::$status[$invoice->status]}}</span>
                                    @endif
                                </td>
                                @if(Gate::check('edit invoice') || Gate::check('delete invoice') || Gate::check('show invoice'))
                                    <td class="text-right">
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['rent.destroy', $invoice->id]]) !!}
                                            @can('create invoice payment')
                                                <a class="text-warning customModal" href="#"
                                                    data-bs-toggle="tooltip" data-title="{{__('Add Payment')}}" data-url="{{ route('rent.payment.create',$invoice->id) }}"
                                                    data-bs-original-title="Payer"> 
                                                    <svg fill="green" xmlns="http://www.w3.org/2000/svg" height="21" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M326.7 403.7c-22.1 8-45.9 12.3-70.7 12.3s-48.7-4.4-70.7-12.3c-.3-.1-.5-.2-.8-.3c-30-11-56.8-28.7-78.6-51.4C70 314.6 48 263.9 48 208C48 93.1 141.1 0 256 0S464 93.1 464 208c0 55.9-22 106.6-57.9 144c-1 1-2 2.1-3 3.1c-21.4 21.4-47.4 38.1-76.3 48.6zM256 84c-11 0-20 9-20 20v14c-7.6 1.7-15.2 4.4-22.2 8.5c-13.9 8.3-25.9 22.8-25.8 43.9c.1 20.3 12 33.1 24.7 40.7c11 6.6 24.7 10.8 35.6 14l1.7 .5c12.6 3.8 21.8 6.8 28 10.7c5.1 3.2 5.8 5.4 5.9 8.2c.1 5-1.8 8-5.9 10.5c-5 3.1-12.9 5-21.4 4.7c-11.1-.4-21.5-3.9-35.1-8.5c-2.3-.8-4.7-1.6-7.2-2.4c-10.5-3.5-21.8 2.2-25.3 12.6s2.2 21.8 12.6 25.3c1.9 .6 4 1.3 6.1 2.1l0 0 0 0c8.3 2.9 17.9 6.2 28.2 8.4V312c0 11 9 20 20 20s20-9 20-20V298.2c8-1.7 16-4.5 23.2-9c14.3-8.9 25.1-24.1 24.8-45c-.3-20.3-11.7-33.4-24.6-41.6c-11.5-7.2-25.9-11.6-37.1-15l-.7-.2c-12.8-3.9-21.9-6.7-28.3-10.5c-5.2-3.1-5.3-4.9-5.3-6.7c0-3.7 1.4-6.5 6.2-9.3c5.4-3.2 13.6-5.1 21.5-5c9.6 .1 20.2 2.2 31.2 5.2c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-6.5-1.7-13.7-3.4-21.1-4.7V104c0-11-9-20-20-20zM48 352H64c19.5 25.9 44 47.7 72.2 64H64v32H256 448V416H375.8c28.2-16.3 52.8-38.1 72.2-64h16c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V400c0-26.5 21.5-48 48-48z"/></svg>
                                                </a>
                                            @endcan
                                            @can('show invoice')
                                                <a class="text-warning" href="{{ route('rent.show',$invoice->id) }}"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('View')}}"> <i
                                                        data-feather="eye"></i></a>
                                            @endcan
                                            @can('edit invoice')
                                                <a class="text-success" href="{{ route('rent.edit',$invoice->id) }}"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}"> <i data-feather="edit"></i></a>
                                            @endcan
                                            @can('delete invoice')
                                                <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                   data-bs-original-title="Supprimer" href="#"> <i
                                                        data-feather="trash-2"></i></a>
                                            @endcan
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

