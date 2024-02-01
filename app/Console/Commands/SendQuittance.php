<?php

namespace App\Console\Commands;

use App\Models\TenantInvoice;
use Illuminate\Console\Command;
use App\Services\EmailService;
use App\Services\RentService;
use App\Models\EmailTemplate;
use App\Models\User;

class SendQuittance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quittance:send {recipients} {invoiceid?} {template?} {parentid?}';
    protected $description = 'Send quittance to a given destinator.';
    protected $emailService;

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function __construct(EmailService $emailService, RentService $rentService)
    {
        parent::__construct();

        $this->emailService = $emailService;
        $this->rentService = $rentService;
    }
    
    public function handle()
    {
        $recipients = $this->argument('recipients');
        $recipientsArray = explode(',', $recipients);

        //$idTemplate = $this->argument('template');
        $idTemplate = 25;
        $parent_id = $this->argument('parentid');
        $invoice_id = $this->argument('invoiceid');
        
        foreach ($recipientsArray as $userID) 
        {
            $template = EmailTemplate::find($idTemplate);
            $tenantInvoice = TenantInvoice::where('invoice_id', '=', $invoice_id)->first();

            $emailSubject = $this->emailService->replaceSubjectVariables($template->sujet, date('m', strtotime($tenantInvoice->invoice_month)));
            $emailContent = $tenantInvoice->replacePlaceholders($template->corps, $tenantInvoice);

            $this->emailService->sendEmail($tenantInvoice, $emailSubject, $emailContent, null, $parent_id);
        }
    }
}
