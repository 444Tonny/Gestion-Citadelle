<!-- resources/views/components/variables.blade.php -->
<div class="col-md-12">
    <div class="form-group">
        {{ Form::label('Variables', 'variable', ['class' => 'form-label']) }}
        <div class='champs_personnalisables'>
            <span class='variable' onclick="copyContent(this, '{First_Name}')">{First_Name}</span>
            <span class='variable' onclick="copyContent(this, '{Last_Name}')">{Last_Name}</span>
            <span class='variable' onclick="copyContent(this, '{Tenant_Address}')">{Tenant_address}</span>
            <span class='variable' onclick="copyContent(this, '{Unit}')">{Unit}</span>
            <span class='variable' onclick="copyContent(this, '{Payment_Total}')">{Payment_Total}</span>
            <span class='variable' onclick="copyContent(this, '{Payment_Due}')">{Payment_Due}</span>
            <span class='variable' onclick="copyContent(this, '{Due_Date}')">{Due_Date}</span>
            <span class='variable' onclick="copyContent(this, '{Current_Month}')">{Current_Month}</span>
            <span class='variable' onclick="copyContent(this, '{Next_Month}')">{Next_Month}</span>
            <span class='variable' onclick="copyContent(this, '{Current_Year}')">{Current_Year}</span>
        </div>
    </div>
</div>
