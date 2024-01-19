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
            <a href="#">Envoi d'email</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @can('create invoice')
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('typeForm') }}"
           data-title="Nouvel envoi"> <i
                class="ti-plus mr-5"></i>
                Nouvel envoi
        </a>
    @endcan
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table id="journalEmailTable" class="display dataTable cell-border datatbl-advance">
                        <thead>
                            <tr>
                                <th id='dateEnvoi' class='sorting_desc'>Date envoi</th>
                                <th>Sujet</th>
                                <th>Destinataire</th>
                                <th>Statut </th>
                                <th>Action </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($journauxEmail as $email)
                            <tr role="row">
                                <td>{{ \Carbon\Carbon::parse($email->date_envoi)->format('d M Y') }}</td>
                                <td> {{ $email->sujet_journal }} </td>
                                <td> {{ $email->email_destinataire }} </td>
                                <td>
                                    <span class="badge {{ $email->statut_journal === 'Echec' ? 'badge-danger' : 'badge-success' }}">
                                        {{ $email->statut_journal }}
                                    </span>
                                </td>    
                                <td style='text-align:center;'>
                                    <form method="POST" action="{{ route('emails.destroy', ['email' => $email->id_journal]) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet email?');">
                                        @csrf
                                        @method('DELETE')
                                        <a class="text-warning customModal" href="#"
                                            data-bs-toggle="tooltip" data-title="Details email" data-url="{{ route('showDetails', $email->id_journal) }}"
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



