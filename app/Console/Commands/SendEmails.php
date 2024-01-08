<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EmailService;
use App\Models\User;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send {recipients?}';
    protected $description = 'Send emails to recipients automatically.';
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
        //$recipients = [9, 10];
        
        foreach ($recipients as $recipient) {

            $user = User::find($recipient);
            $this->emailService->sendEmail($user, 'Auto sujet', 'Corps auto');
        }
    }
}
