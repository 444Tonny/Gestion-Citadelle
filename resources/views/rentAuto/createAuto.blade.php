<head>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <style>
        .thin{
            font-weight: 100 !important;
        }

        .selected
        {
            border: 1px #f3f3f3 solid;
            padding: 10px;
            color: #8d9bac;
            border-radius: 3px;
        }
        .form-control:disabled
        {
            opacity: 0.4 !important;
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
            <a href="{{route('rentAuto.index')}}">Loyers automatiques</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Create')}}</a>
        </li>
    </ul>
@endsection

@section('content')

{{Form::open(array('url'=>'rentAuto','method'=>'post', 'id'=>'templateForm'))}}
    <div class="modal-body">
        <div class="row">

            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <br>
                            {{Form::label('name_task', 'Nom de la tâche', array('class'=>'form-label'))}}
                            {{Form::text('name_task','', array('class'=>'form-control','placeholder'=> 'Nom...' ,'required'=>'required'))}}
                        </div>
                    </div>
                </div>
            </div>
                    
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-md-6 col-lg-6">
                            <label for="interval" class="form-label">Fréquence</label>
                            <select id="intervalSelect" name="interval" class="form-control">
                                <option value="7">Par semaine</option>
                                <option value="30">Par mois</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6 col-lg-6">
                            <label for="dayOfMonth" class="form-label">Jours du mois</label>
                            <input id='dayOfMonth' type="number" name="dayOfMonth" class="form-control" placeholder="1-31" min="1" max="31" value='*' required>
                        </div>

                        <div class="form-group col-md-6 col-lg-6">
                            {{ Form::label('day', 'Jours de la semaine', ['class' => 'form-label']) }}
                            <select id="daySelect" class="form-control" name="day[]" style='height: 160px;' multiple>
                                <option value="*">Tous les jours</option>
                                <option value="1">Lundi</option>
                                <option value="2">Mardi</option>
                                <option value="3">Mercredi</option>
                                <option value="4">Jeudi</option>
                                <option value="5">Vendredi</option>
                                <option value="6">Samedi</option>
                                <option value="7">Dimanche</option>
                            </select>
                            <br>
                            <div id="selectedDays"></div>
                        </div>
            
                        <div class="form-group col-md-6 col-lg-6">
                            {{ Form::label('month', 'Mois du début', ['class' => 'form-label']) }}
                            <select id="monthSelect" class="form-control" name="month[]" style='height: 160px;' multiple>
                                <option value="*">Tous les mois</option>
                                <option value="1">Janvier</option>
                                <option value="2">Février</option>
                                <option value="3">Mars</option>
                                <option value="4">Avril</option>
                                <option value="5">Mai</option>
                                <option value="6">Juin</option>
                                <option value="7">Juillet</option>
                                <option value="8">Août</option>
                                <option value="9">Septembre</option>
                                <option value="10">Octobre</option>
                                <option value="11">Novembre</option>
                                <option value="12">Décembre</option>
                            </select>
                            <br>
                            <div id="selectedMonths"></div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var intervalSelect = document.getElementById('intervalSelect');
                                intervalSelect.addEventListener('change', handleIntervalChange);

                                var daySelect = document.getElementById('daySelect');
                                var selectedDaysContainer = document.getElementById('selectedDays');

                                var monthSelect = document.getElementById('monthSelect');
                                var selectedMonthsContainer = document.getElementById('selectedMonths');

                                var dayOfMonthInput = document.getElementById('dayOfMonth');

                                handleIntervalChange();

                                // Gérer le changement dans le champ de sélection de la fréquence
                                daySelect.addEventListener('change', function() {
                                    var selectedOptions = Array.from(daySelect.selectedOptions).map(function(option) {
                                        return option.text;
                                    });

                                    selectedDaysContainer.innerHTML = 'Sélection(s) : ' + selectedOptions.join(', ');
                                    selectedDaysContainer.classList.add('selected');
                                });


                                monthSelect.addEventListener('change', function() {
                                    var selectedOptions = Array.from(monthSelect.selectedOptions).map(function(option) {
                                        return option.text;
                                    });

                                    selectedMonthsContainer.innerHTML = 'Sélection(s) : ' + selectedOptions.join(', ');
                                    selectedMonthsContainer.classList.add('selected');
                                });

                                // Bloquer le select Month
                                function handleIntervalChange() {
                                    var selectedInterval = intervalSelect.value;

                                    // Si la fréquence est "Chaque mois", désactivez le champ de sélection des jours
                                    if (selectedInterval === '30') {
                                        daySelect.disabled = true;
                                        daySelect.value = '*'; 

                                        monthSelect.disabled = false;
                                        dayOfMonthInput.disabled = false;
                                    } else {
                                        daySelect.disabled = false;

                                        dayOfMonthInput.disabled = true;
                                        dayOfMonthInput.value = '*';
                                    }
                                }
                            });
                        </script>
                        
                        <div class="form-group col-md-6 col-lg-6">
                            <label for="time" class="form-label">Heure</label>
                            <input type="time" name="time" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6 col-lg-6">
                            <label for="timezone" class="form-label">Fuseau horaire</label>
                            <select name="timezone" class="form-control" required>
                                <option value="America/Montreal" selected>Eastern Time (ET) - Montréal</option>
                                <option value="America/Toronto">Eastern Time (ET) - Toronto</option>
                                <option value="America/New_York">Eastern Time (ET) - New York</option>
                                <option value="America/Vancouver">Pacific Time (PT) </option>
                                <option value="America/Chicago">Central Time (CT)</option>
                                <option value="America/Denver">Mountain Time (MT)</option>
                            </select>
                        </div>


                        <!--                
                        <div class="form-group col-md-6 col-lg-6">
                            {{ Form::label('dayOfWeek', 'Jours de la semaine',['class'=>'form-label']) }}
                            {{ Form::text('dayOfWeek', null, ['class' => 'form-control', 'placeholder' => '0-6 (Dimanche-Samedi)']) }}
                        </div>
                        -->
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <br>
                            {{ Form::label('Destinataires', 'Destinataires',['class'=>'form-label']) }}
                            <br>
                            <!--
                            <input type="checkbox" id="checkbox1" onchange="checkSpecificType(this, 'tenant')">     
                            {{ Form::label('', 'Tous les locataires',['class'=>'form-label thin']) }}
                            -->
                            @foreach($properties as $id_property => $name)
                                <input type="checkbox" id="checkbox1" name='recipients[]' value="{{ $id_property }}">     
                                <label class=' thin'>Locataires de : <b>{{ $name }}</b></label>
                            @endforeach
                            <br>
                            <br>
                        </div>  
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        {{Form::label('Sujet', 'Sujet', array('class'=>'form-label'))}}
                        <br>
                        {{Form::text('sujet',$template[0]->sujet, array('class'=>'form-control','placeholder'=> 'Sujet...' ,'required'=>'required', 'readonly'=>'readonly'))}}
                    </div>

                    <div class="previewEmail">
                        {!! $template[0]->corps !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type='hidden' name='corps_code' class='corps_code' value=''>
        <input type='hidden' name='id_modele' value='{{ $template[0]->id_modele }}'>
        <button type='submit' id='submitTemplate' class='btn btn-primary ml-10'>Créer</button>
    </div>

    
    <script src="{{ asset('js/summernote.js') }}"></script>
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

        function checkSpecificProperty(checkbox, property) {
            var dataTable = $('.dataTable').DataTable();

            if (checkbox.checked) {
                // La case à cocher est cochée, sélectionnez toutes les cases à cocher de la même propriété
                var checkboxes = dataTable.rows().nodes().to$().find('.checkboxUser[data-property="' + property + '"]');
                checkboxes.each(function () {
                    this.checked = true;
                });
            } else {
                // La case à cocher est décochée, décochez toutes les cases à cocher de la même propriété
                var checkboxes = dataTable.rows().nodes().to$().find('.checkboxUser[data-property="' + property + '"]');
                checkboxes.each(function () {
                    this.checked = false;
                });
            }
        }

        function checkAll(checkbox) 
        {
            var dataTable = $('.dataTable').DataTable();
            var checkboxes = dataTable.rows().nodes().to$().find('.checkboxUser');
            checkboxes.each(function () {
                this.checked = checkbox.checked;
            });
        }
    </script>

    {{Form::close()}}
@endsection
