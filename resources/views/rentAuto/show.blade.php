<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12 details_email">
            <br>
            <label><b>Email</b></label>
            <br>
            <span>{{ $trigger->type }}</span>
            <br><br>
            <label><b>Destinataires</b></label>
            <br><br>
            <div class="form-group col-md-12 col-lg-12" id="recipientContainer" style="display: none;">
                <select name="timezone" class="form-control" required>
                    @foreach($otherUsers as $otherUser)
                    <option value="{{ $otherUser->id }}" onclick='addRecipient({{ $otherUser->id }}, {{ $trigger->id_trigger }})' selected>{{ $otherUser->email }} - {{ $otherUser->first_name }} {{ $otherUser->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" id="toggleRecipientBtn" class="btn btn-primary" onclick="toggleRecipientContainer(this)">Ajouter destinataire</button>
            <div id="recipients">
                @foreach($recipients as $user)
                    <form id="deleteForm{{ $user->id }}" action="{{ route('delete.recipient', ['id' => $user->id, 'triggerId' => $trigger->id_trigger]) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn-remove" onclick="deleteRecipient({{ $user->id }}, {{ $trigger->id_trigger }})">×</button>
                        <span>{{ $user->email }} ({{ $user->first_name }} {{ $user->last_name }})</span>
                        <br>
                    </form>
                @endforeach
            </div>
            <br>
        </div>
    </div>
</div>

<script>
    function toggleRecipientContainer(button) {
        var recipientContainer = document.getElementById('recipientContainer');
        recipientContainer.style.display = (recipientContainer.style.display === 'none') ? 'block' : 'none';
        button.style.display = 'none';
    }

    function deleteRecipient(userId, triggerId) {
        if (confirm("Voulez vous supprimer l'utilisateur de la liste?")) {
            fetch(`{{ url('rentAuto/delete-recipient') }}/${userId}/${triggerId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            })
            .then(response => {
                if (response.ok) {
                    // Remove the deleted user's form from the DOM
                    const formElement = document.getElementById('deleteForm' + userId);
                    formElement.parentNode.removeChild(formElement);

                    console.log('User deleted successfully');
                } else {
                    console.error('Failed to delete user');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }

    function addRecipient(userId, triggerId) {
        fetch(`{{ url('rentAuto/add-recipient') }}/${userId}/${triggerId}`, {
            method: 'POST',  // Change the method to POST
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
        .then(response => response.json())  // Assuming the server returns JSON
        .then(data => {
            if (data.success) 
            {
                // Create a new form element for the added recipient
                const recipientsContainer = document.getElementById('recipients');
                const newForm = document.createElement('form');
                newForm.id = 'deleteForm' + userId;
                newForm.action = `{{ route('delete.recipient', ['id' => ':userId', 'triggerId' => ':triggerId']) }}`
                        .replace(':userId', userId)
                        .replace(':triggerId', triggerId);
                newForm.method = 'post';
                newForm.innerHTML = `
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-remove" onclick="deleteRecipient(${userId}, ${triggerId})">×</button>
                    <span>${data.email} (${data.first_name} ${data.last_name})</span><br>
                `;

                recipientsContainer.insertBefore(newForm, recipientsContainer.firstChild);
            } else {
                console.error('Failed to add user');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

</script>

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
    form
    {
        display: flex;
        flex-direction: row;
        margin-top: 12px;
        margin-bottom: 12px;
        align-items: center;
    }
    .btn-remove
    {
        border: none;
        height: 20px;
        width: 28px;
        border-radius: 1px;
        display: flex;
        justify-content: center;
        align-content: center;
        align-items: center;
        margin-right: 10px;
        padding-bottom: 1px;
        background-color: #ff8a8a;
        color: white;
        font-weight: 400;
        font-size: 18px;
        transition: 0.2s;
    }
    .btn-remove:hover
    {
        transition: 0.2s;
        cursor: pointer;
        background-color: #e34c4c;
    }
    #toggleRecipientBtn
    {
        margin-bottom: 10px;
    }
</style>