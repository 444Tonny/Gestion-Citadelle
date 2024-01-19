<?php

namespace App\Console\Commands;

use App\Models\TenantInvoice;
use Illuminate\Console\Command;
use App\Services\EmailService;
use App\Models\EmailTemplate;
use App\Models\User;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send {recipients?} {template?} {parentid?}';
    protected $description = 'Send emails to multiple recipients automatically with a given template.';
    protected $emailService;

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function __construct(EmailService $emailService)
    {
        parent::__construct();
        $this->emailService = $emailService;
    }
    
    public function handle()
    {
        $recipients = $this->argument('recipients');
        $recipientsArray = explode(',', $recipients);

        $idTemplate = $this->argument('template');
        $parent_id = $this->argument('parentid');

        dump($recipients);
        
        foreach ($recipientsArray as $recipient) {

            $user = TenantInvoice::find($recipient);
            $template = EmailTemplate::find($idTemplate);

            $emailContent = $user->replacePlaceholders($template->corps, 'UTF-8', 'ISO-8859-1');

            $this->emailService->sendEmail($user, $template->sujet, $emailContent, null, $parent_id);
        }
    }
}
