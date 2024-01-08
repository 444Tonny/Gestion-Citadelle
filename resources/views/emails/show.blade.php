<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12 details_email">
            <br>
            <label><b>Destinataire</b></label>
            <br>
            <span>{{ $journal->email_destinataire }}</span>
            <br><br>
            <label><b>Sujet</b></label>
            <br>
            <span>{{ $journal->sujet_journal }}</span>
            <br><br>
            <label><b>Status</b></label>
            <br>
            <span class="badge {{ $journal->statut_journal === 'Echec' ? 'badge-danger' : 'badge-success' }}">
                {{ $journal->statut_journal }}
            </span>
            <br><br>
            <label><b>Message</b></label>
            <br>
            <span>{!! $journal->raison_echec !!}</span>
            <br><br>
            <label><b>Date d'envoi</b></label>
            <br>
            <span>{{ $journal->date_envoi }}</span>
            <br><br>
            <label><b>Contenu</b></label>
            <br><br>
            <span>{!! $journal->corps_journal !!}</span>
            <br>
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