@extends('layouts.app')
@section('page-title')
    {{__('Expense')}}
@endsection
@push('script-page')

@endpush
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Expense')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @can('create expense')
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="{{ route('expense.create') }}"
           data-title="{{__('Create Expense')}}"> <i class="ti-plus mr-5"></i>{{__('Create Expense')}}</a>
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
                            <th>{{__('Expense')}}</th>
                            <th>{{__('Title')}}</th>
                            <th>{{__('Property')}}</th>
                            <th>{{__('Unit')}}</th>
                            <th>{{__('Type')}}</th>
                            <th>{{__('Date')}}</th>
                            <th>{{__('Amount')}}</th>
                            <th>{{__('Receipt')}}</th>
                            @if(Gate::check('edit expense') || Gate::check('delete expense') || Gate::check('show expense'))
                                <th class="text-right">{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expenses as $expense)
                            <tr role="row">
                                <td>{{\App\Models\Custom::expensePrefix().$expense->expense_id}} </td>
                                <td> {{$expense->title}} </td>
                                <td> {{!empty($expense->properties)?$expense->properties->name:'-'}} </td>
                                <td> {{!empty($expense->units)?$expense->units->name:'-'}} </td>
                                <td> {{!empty($expense->types)?$expense->types->title:'-'}} </td>
                                <td> {{\Auth::user()->dateFormat($expense->date)}} </td>
                                <td> {{\Auth::user()->priceFormat($expense->amount)}} </td>
                                <td>
                                    @if(!empty($expense->receipt))
                                        <a href="{{asset(Storage::url('upload/receipt')).'/'.$expense->receipt}}"
                                           download="download"><i data-feather="download"></i></a>
                                    @else
                                        -
                                    @endif
                                </td>
                                @if(Gate::check('edit expense') || Gate::check('delete expense') || Gate::check('show expense'))
                                    <td class="text-right">
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['expense.destroy', $expense->id]]) !!}
                                            @can('show expense')
                                                <a class="text-warning customModal" data-size="lg"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('View')}}" href="#"
                                                   data-url="{{ route('expense.show',$expense->id) }}"
                                                   data-title="{{__('Expense Details')}}"> <i
                                                        data-feather="eye"></i></a>
                                            @endcan
                                            @can('edit expense')
                                                <a class="text-success customModal" data-size="lg"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}" href="#"
                                                   data-url="{{ route('expense.edit',$expense->id) }}"
                                                   data-title="{{__('Edit Expense')}}"> <i data-feather="edit"></i></a>
                                            @endcan
                                            @can('delete expense')
                                                <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Detete')}}" href="#"> <i
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

