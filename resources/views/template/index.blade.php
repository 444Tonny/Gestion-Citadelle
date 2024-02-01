@extends('layouts.app')
@section('page-title')
    {{__('Invoice')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">Email Templates</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @can('create invoice')
        <a class="btn btn-primary btn-sm ml-20" href="{{ route('template.create') }}"> <i
                class="ti-plus mr-5"></i>Créer une template</a>
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
                                <th>Nº</th>
                                <th>Nom</th>
                                <th>Sujet</th>
                                @if(Gate::check('edit invoice') || Gate::check('delete invoice') || Gate::check('show invoice'))
                                    <th class="text-right">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($emailTemplates as $template)
                            <tr role="row">
                                <td>{{ $template->id_modele }} </td>
                                <td>{{ $template->nom_modele }}  </td>
                                <td>{{ $template->sujet }} </td>
                                <td>
                                <form method="POST" action="{{ route('template.destroy', ['template' => $template->id_modele]) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce modèle?');">
                                    @csrf
                                    @method('DELETE')
                                    @can('edit invoice')
                                        <a class="text-success" href="{{ route('template.edit',$template) }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="{{__('Edit')}}"> <i data-feather="edit"></i></a>
                                    @endcan
                                    
                                    @can('delete invoice')
                                        @if($template->is_deletable == 1)
                                            <button type='submit' style='background:none;border:none;'> 
                                                <i data-feather="trash-2" style='color:red;'></i></a>
                                            </button>
                                        @endif
                                    @endcan
                                </form>
                                </td>                        
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

