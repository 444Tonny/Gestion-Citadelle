<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12 details_email">
            <br>
            <label><b>Tâche</b></label>
            <br>
            <span>{{ $trigger->name_task }}</span>
            <br><br>
            <label><b>Destinataires</b></label>
            <br>
                @foreach($recipients as $user)
                    <span>{{ $user->email }} ({{ $user->first_name }} {{ $user->last_name }})</span>
                    <br>
                @endforeach
            <br>
            
            <table class="display dataTable cell-border datatbl-advance">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkboxSelectAll" onchange="checkAll(this)"></th>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Propriété</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr role='row'>
                        <td><input type="checkbox" class="checkboxUser" name='selectedUsers[]' data-type='{{ $user->type }}' data-property='{{ $user->property_name }}' value='{{ $user->id }}'></td>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class='userType'>{{ $user->type }}</td>
                        <td class='userProperty'>{{ $user->property_name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .details_email b
    {
        font-size: 16px !important;
        margin-bottom: 10px !important;
    }

    .details_email span
    {
        font-size: 14px !important;
        opacity: 0.8;
    }
</style>