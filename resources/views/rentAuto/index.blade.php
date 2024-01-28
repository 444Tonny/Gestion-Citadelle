@extends('layouts.app')
@section('page-title')
    Loyers automatiques
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">Loyers automatiques</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('rentAuto.chooseTemplate') }}"
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
                                <th>Tâche</th>
                                <th>Occurence</th>
                                <th>Timezone</th>
                                <th>Statut </th>
                                <th>Action </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($triggers as $trigger)
                            <tr role="row">
                                <td> {{ $trigger->name_task }} </td>
                                <td> {{ $trigger->readableExpression  }} </td>
                                <td>{{ $trigger->timezone }}</td>
                                <td style='display:flex;justify-content:center;align-items:center;height:50px;'>
                                    <div class="toggle-switch" id="toggleSwitch1" data-active='{{ $trigger->is_active }}'>
                                        <input type="checkbox" class="switch-checkbox" data-id='{{ $trigger->id_trigger }}' name='switchTrigger{{ $trigger->id_trigger }}' id="switch1" />
                                        <label for="switch1" class="switch-label">
                                            <div class="switch-handle"></div>
                                        </label>
                                    </div>
                                </td>    
                                <td style='text-align:center;'>
                                    <form method="POST" action="{{ route('rentAuto.destroy', ['rentAuto' => $trigger->id_trigger]) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce déclencheur?');">
                                        @csrf
                                        @method('DELETE')

                                        <a class="text-warning customModal" href="#" data-title="Details Tâche" data-url="{{ route('showTaskDetails', $trigger->id_trigger) }}"
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

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            var toggleSwitches = document.querySelectorAll(".toggle-switch");

                            toggleSwitches.forEach(function (toggleSwitch) {
                                var checkbox = toggleSwitch.querySelector(".switch-checkbox");

                                // Utilisez l'attribut data-active pour définir l'état initial
                                var initialActiveState = toggleSwitch.getAttribute("data-active");
                                var idCheckbox = checkbox.getAttribute("data-id");

                                if (initialActiveState === 'enabled') {
                                    checkbox.checked = true;
                                }

                                // Mettez à jour l'apparence du commutateur lors du chargement de la page
                                updateSwitchAppearance(checkbox);

                                toggleSwitch.addEventListener("click", function () {
                                    checkbox.checked = !checkbox.checked;
                                    updateSwitchAppearance(checkbox);

                                    // Envoyer la requête AJAX pour mettre à jour l'état du trigger
                                    var newActiveState = checkbox.checked ? 'enabled' : 'disabled';
                                    updateTriggerState(newActiveState, idCheckbox);
                                });
                            });

                            function updateSwitchAppearance(checkbox) {
                                var switchLabel = checkbox.nextElementSibling;
                                var switchHandle = switchLabel.querySelector(".switch-handle");
                                switchHandle.style.transform = checkbox.checked ? "translateX(135%)" : "translateX(0)";

                                // Ajoutez ou supprimez la classe switch-enabled en fonction de l'état
                                var toggleSwitch = checkbox.closest('.toggle-switch');
                                if (checkbox.checked) {
                                    toggleSwitch.classList.add('switch-enabled');
                                } else {
                                    toggleSwitch.classList.remove('switch-enabled');
                                }
                            }

                            function updateTriggerState(newActiveState, idCheckbox) 
                            {
                                var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                                // Requête AJAX pour mettre à jour l'état du trigger
                                
                                fetch("{{ route('updateState') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": csrfToken,
                                    },
                                    body: JSON.stringify({ newActiveState: newActiveState, idCheckbox: idCheckbox }),
                                })
                                .then(response => response)
                                .then(data => {
                                    console.log("État du trigger mis à jour avec succès !");
                                })
                                .catch(error => {
                                    console.error("Erreur lors de la mise à jour de l'état du trigger :", error);
                                });
                            }
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
@endsection
