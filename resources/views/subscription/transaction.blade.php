@extends('layouts.app')
@section('page-title')
    {{__('Transaction')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Transaction')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance" >
                        <thead>
                        <tr>
                            <th>{{__('User')}}</th>
                            <th>{{__('Date')}}</th>
                            <th>{{__('Subscription')}}</th>
                            <th>{{__('Price')}}</th>
                            <th>{{__('Payment Type')}}</th>
                            <th>{{__('Receipt')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{$transaction->name}}</td>
                                <td>{{\Auth::user()->dateFormat($transaction->created_at)}}</td>
                                <td>{{$transaction->subscription}}</td>
                                <td>{{(!empty(env('CURRENCY_SYMBOL'))?env('CURRENCY_SYMBOL'):'$').$transaction->price}}</td>
                                <td>{{$transaction->payment_type}}</td>
                                <td>
                                    <a class="text-success" data-bs-toggle="tooltip" target="_blank" data-bs-original-title="{{__('Receipt')}}" href="{{$transaction->receipt}}"  data-title="{{__('Edit Support')}}"> <i data-feather="file"></i></a>

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

