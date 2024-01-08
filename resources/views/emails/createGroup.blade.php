<head>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>  

    <style>
        .thin{
            font-weight: 100 !important;
        }
    </style>
</head>

@extends('layouts.app')
@section('page-title')
    Email
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('emails.index')}}">Emails</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Create')}}</a>
        </li>
    </ul>
@endsection

@section('content')
    {{ Form::open(['route' => 'sendGroup', 'method' => 'post', 'id' => 'templateForm']) }}

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('Destinataires', 'Destinataire',['class'=>'form-label']) }}
                    <br>
                    <input type="checkbox" id="checkbox1" onchange="checkSpecificType(this, 'tenant')">     
                    {{ Form::label('', 'Tous les locataires',['class'=>'form-label thin']) }}
                    <br>
                    <input type="checkbox" id="checkbox1" onchange="checkSpecificType(this, 'manager')">     
                    {{ Form::label('', 'Tous les managers',['class'=>'form-label thin']) }}
                    <br>
                    <input type="checkbox" id="checkbox1" value='tenant' onchange="checkSpecificType(this, 'maintainer')">     
                    {{ Form::label('', 'Tous les maintainers',['class'=>'form-label thin']) }}
                </div>  
            </div>


            <table class="display dataTable cell-border datatbl-advance">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkboxSelectAll" onchange="checkAll(this)"></th>
                        <th>Email</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr role='row'>
                        <td><input type="checkbox" class="checkboxUser" name='selectedUsers[]' data-type='{{ $user->type }}' value='{{ $user->id }}'></td>
                        <td>{{ $user->email }}</td>
                        <td class='userType'>{{ $user->type }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('Sujet', 'Sujet', array('class'=>'form-label'))}}
                    {{Form::text('sujet',$template[0]->sujet, array('class'=>'form-control','placeholder'=> 'Sujet...' ,'required'=>'required'))}}
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('Variables', 'variable', array('class'=>'form-label'))}}
                    <div class='champs_personnalisables'>
                        <span class='variable' onclick="copyContent(this, '{First_Name}')">{First_Name}</span>
                        <span class='variable' onclick="copyContent(this, '{Last_Name}')">{Last_Name}</span>
                        <span class='variable' onclick="copyContent(this, '{Payment_Total}')">{Payment_Total}</span>
                        <span class='variable' onclick="copyContent(this, '{Payment_Due}')">{Payment_Due}</span>
                        <span class='variable' onclick="copyContent(this, '{Invoice_Month}')">{Invoice_Month}</span>
                    </div>
                </div>
            </div>            

            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('Corps', 'Corps', array('class'=>'form-label'))}}
                    <textarea id="corps_modele" class='corps_modele' name="corps_modele"></textarea>
                </div>
            </div>

            <script>
                function checkSpecificType(checkbox, userType) {
                    var dataTable = $('.dataTable').DataTable();
    
                    if (checkbox.checked) {
                        // La case à cocher est cochée, sélectionnez toutes les cases à cocher du même type
                        var checkboxes = dataTable.rows().nodes().to$().find('.checkboxUser[data-type="' + userType + '"]');
                        checkboxes.each(function () {
                            this.checked = true;
                        });
                    } else {
                        // La case à cocher est décochée, décochez toutes les cases à cocher du même type
                        var checkboxes = dataTable.rows().nodes().to$().find('.checkboxUser[data-type="' + userType + '"]');
                        checkboxes.each(function () {
                            this.checked = false;
                        });
                    }
                }

                function checkAll(checkbox) {

                    var dataTable = $('.dataTable').DataTable();

                    var checkboxes = dataTable.rows().nodes().to$().find('.checkboxUser');
                    checkboxes.each(function () {
                        this.checked = checkbox.checked;
                    });
                }
            </script>
            
        </div>
    </div>

    <div class="modal-footer">
        <input type='hidden' name='corps_code' class='corps_code' value=''>
        <a class="btn btn-secondary" href="{{route('emails.index')}}">Retour</a>
        <button type='button' id='submitTemplate' class='btn btn-primary ml-10' onclick=getCode()>Envoyer</button>
    </div>

    
    <script src="{{ asset('js/summernote.js') }}"></script>
    <script>
        $(document).ready(function() {
            var contenuHTML = `<?php echo $template[0]->corps; ?>`;

            $('.note-editable').html(contenuHTML);
        });
    </script>

    {{Form::close()}}
@endsection