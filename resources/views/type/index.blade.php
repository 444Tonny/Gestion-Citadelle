@extends('layouts.app')
@section('page-title')
    {{__('Types')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Types')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @can('create types')
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('type.create') }}"
           data-title="{{__('Create Type')}}"> <i class="ti-plus mr-5"></i>{{__('Create Type')}}</a>
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
                            <th>{{__('Title')}}</th>
                            <th>{{__('Type')}}</th>
                            @if(Gate::check('edit types') || Gate::check('delete types'))
                                <th class="text-right">{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($types as $type)
                            <tr role="row">
                                <td>
                                    {{$type->title}}
                                </td>
                                <td>
                                    {{\App\Models\Type::$types[$type->type]}}
                                </td>
                                @if(Gate::check('edit types') || Gate::check('delete types'))
                                    <td class="text-right">
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['type.destroy', $type->id]]) !!}
                                            @can('edit types')
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}" href="#"
                                                   data-url="{{ route('type.edit',$type->id) }}"
                                                   data-title="{{__('Edit Type')}}"> <i data-feather="edit"></i></a>
                                            @endcan
                                            @can('delete types')
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

