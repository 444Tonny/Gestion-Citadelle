<head>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>  
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
            Preview
        </li>
    </ul>
@endsection

@section('content')
    {{ Form::open(['route' => 'sendEmail', 'method' => 'post']) }}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <h1 class='head_previewEmail'>Aperçu email</h1>
                <br>

                <div class="form-group">
                    {{Form::label('Destinataire', 'Destinataire', array('class'=>'form-label'))}}
                    <br>
                    {{Form::text('destinatairePlaceholder',$destinatairePlaceholder, array('class'=>'form-control','placeholder'=> 'Destinataire...' ,'required'=>'required', 'readonly'=>'readonly'))}}
                </div>
                
                <div class="form-group">
                    {{Form::label('Sujet', 'Sujet', array('class'=>'form-label'))}}
                    <br>
                    {{Form::text('sujet',$sujet, array('class'=>'form-control','placeholder'=> 'Sujet...' ,'required'=>'required', 'readonly'=>'readonly'))}}
                </div>

                <div class="previewEmail">
                    <?php echo mb_convert_encoding(base64_decode($contenuMail), 'UTF-8', 'ISO-8859-1') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type='hidden' name='sujet' value='{{ $sujet }}'>
        <input type='hidden' name='contenuMail' value='{!! $contenuMail !!}'>
        <input type='hidden' name='destinataire' value='{{ $destinataireId }}'>
        <a class="btn btn-secondary" href="{{route('emails.index')}}">Annuler</a>
        <button class="btn btn-primary" type="submit" data-bs-dismiss="modal">Envoyer</button>
    </div>
    {{Form::close()}}
@endsection