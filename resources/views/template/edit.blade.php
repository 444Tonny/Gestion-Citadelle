<head>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>  
</head>

@extends('layouts.app')
@section('page-title')
    Email templates
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('template.index')}}">Email Templates</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Create')}}</a>
        </li>
    </ul>
@endsection

@section('content')
    {{ Form::model($template, array('route' => array('template.update', $template), 'method' => 'PUT', 'id'=>'templateForm')) }}

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('Nom', 'Nom du modèle', array('class'=>'form-label'))}}
                    {{Form::text('nom_modele',$template->nom_modele,array('class'=>'form-control','placeholder'=> 'Nom du modèle...' ,'required'=>'required'))}}
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('Sujet', 'Sujet', array('class'=>'form-label'))}}
                    {{Form::text('sujet',$template->sujet,array('class'=>'form-control','placeholder'=> 'Sujet...' ,'required'=>'required'))}}
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('Variables', 'variable', array('class'=>'form-label'))}}
                    <div class='champs_personnalisables'>
                    <span class='variable' onclick="copyContent(this, '{First_Name}')">{First_Name}</span>
                        <span class='variable' onclick="copyContent(this, '{Last_Name}')">{Last_Name}</span>
                        <span class='variable' onclick="copyContent(this, '{Tenant_Address}')">{Tenant_address}</span>
                        <span class='variable' onclick="copyContent(this, '{Payment_Total}')">{Payment_Total}</span>
                        <span class='variable' onclick="copyContent(this, '{Payment_Due}')">{Payment_Due}</span>
                        <span class='variable' onclick="copyContent(this, '{Due_Date}')">{Due_Date}</span>
                        <span class='variable' onclick="copyContent(this, '{Current_Month}')">{Current_Month}</span>
                        <span class='variable' onclick="copyContent(this, '{Current_Year}')">{Current_Year}</span>
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
                $(document).ready(function() {
                    var contenuHTML = `<?php echo $template->corps; ?>`;

                    $('.note-editable').html(contenuHTML);
                });
            </script>
            <script src="{{ asset('js/summernote.js') }}"></script>

        </div>
    </div>

    <div class="modal-footer">
        <input type='hidden' name='corps_code' class='corps_code' value=''>
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
        <button type='button' id='submitTemplate' class='btn btn-primary ml-10' onclick=getCode()>{{ __('Update') }}</button>
    </div>

    {{Form::close()}}
@endsection