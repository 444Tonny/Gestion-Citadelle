<?php

namespace App\Console\Commands;

use App\Models\TenantInvoice;
use Illuminate\Console\Command;
use App\Services\EmailService;
use App\Services\RentService;
use App\Models\EmailTemplate;
use App\Models\User;

class SendRent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rent:send {recipients?} {template?} {parentid?}';
    protected $description = 'Send emails to multiple recipients automatically with a given template.';
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

        $idTemplate = $this->argument('template');
        $parent_id = $this->argument('parentid');

        dump($recipients);
        
        foreach ($recipientsArray as $propertyID) {

            // Parcourir les id de propriété 
            $this->rentService->generateRent($propertyID);

            // Récupérer les utilisateurs/tenants actives de chaque propriété
            
            // Pour chacun, recupérer sles infos sur son unité ET générer une facture
            
            // Envoyer un email avec cette facture

            $template = EmailTemplate::find($idTemplate);

            // $emailContent = $user->replacePlaceholders($template->corps, 'UTF-8', 'ISO-8859-1');

            // $this->emailService->sendEmail($user, $template->sujet, $emailContent, null, $parent_id);
        }
    }
}
