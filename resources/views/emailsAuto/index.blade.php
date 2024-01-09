@extends('layouts.app')
@section('page-title')
    Emails
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">Emails automatiques</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('newAutoForm') }}"
           data-title="Nouvel envoi"> <i
                class="ti-plus mr-5"></i>
                Nouveau
        </a>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table id="journalEmailTable" class="display dataTable cell-border datatbl-advance">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sujet</th>
                                <th>Occurence</th>
                                <th>Statut </th>
                                <th>Action </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($triggers as $trigger)
                            <tr role="row">
                                <td> {{ $trigger->id_trigger }} </td>
                                <td> {{ $trigger->type }} </td>
                                <td> {{ $trigger->readableExpression  }} </td>
                                <td>
                                    <span class="badge {{ $trigger->is_active === false ? 'badge-danger' : 'badge-success' }}">
                                        {{ $trigger->is_active }}
                                    </span>
                                </td>    
                                <td style='text-align:center;'>
                                    <form method="POST" action="{{ route('emailsAuto.destroy', ['emailsAuto' => $trigger->id_trigger]) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce déclencheur?');">
                                        @csrf
                                        @method('DELETE')
                                        <a class="text-warning customModal" href="#"
                                        
                                            data-bs-original-title="Details"> 
                                            <i data-feather="eye"></i>
                                        </a>

                                        <button type='submit' style='background:none;border:none;'> 
                                            <i data-feather="trash-2" style='color:red;'></i></a>
                                        </button>
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
