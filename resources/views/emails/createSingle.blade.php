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
            <a href="#">{{__('Create')}}</a>
        </li>
    </ul>
@endsection

@section('content')
    {{Form::open(array('url'=>'emails','method'=>'post', 'id'=>'templateForm'))}}

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('template', 'Destinataire',['class'=>'form-label']) }}
                    <br>
                    <select class='form-control hidesearch' name='destinataire' required>
                        @foreach($users as $user)
                        <option value='{{ $user->id }}'>{{ $user->email }} - ({{ $user->first_name }} {{ $user->last_name }})</option>
                        @endforeach
                    </select>
                </div>  
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('Sujet', 'Sujet', array('class'=>'form-label'))}}
                    {{Form::text('sujet',$template[0]->sujet, array('class'=>'form-control','placeholder'=> 'Sujet...' ,'required'=>'required'))}}
                </div>
            </div>

            @component('components.variables')
            @endcomponent      

            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('Corps', 'Corps', array('class'=>'form-label'))}}
                    <textarea id="corps_modele" class='corps_modele' name="corps_modele"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type='hidden' name='corps_code' class='corps_code' value=''>
        <a class="btn btn-secondary" href="{{route('emails.index')}}">Retour</a>
        <button type='button' id='submitTemplate' class='btn btn-primary ml-10' onclick=getCode()>Voir aperçu</button>
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
