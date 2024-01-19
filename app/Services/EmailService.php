<?php

// App\Services\EmailService.php
namespace App\Services;

use App\Models\JournalEmail;
use App\Mail\CitadelleEmail;
use App\Models\TenantInvoice;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function replaceSubjectVariables($message)
    {    
        $currentMonth = date('n'); // Numéro du mois actuel

        $months = [
            'fr' => [
                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
            ],
            'en' => [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ],
            // Ajoutez d'autres langues au besoin
        ];
    
        // Remplacer [Mois] par le mois actuel en français
        $message = str_replace('[Mois]', $months['fr'][$currentMonth - 1], $message);
    
        // Remplacer [Month] par le mois actuel en anglais
        $message = str_replace('[Month]', $months['en'][$currentMonth - 1], $message);
    
        return $message;
    }

    public function sendMassEmail($destinataires, $sujet, $htmlContent)
    {
        $is_sent = [];

        foreach ($destinataires as $i => $userID) {
            
            $destinataire = TenantInvoice::find($userID);
            $message = '';

            // Pas d'invoice
            if($destinataire == null) 
            {
                $destinataire = User::find($userID);
                $message = "L'utilisateur n'a pas de facture à payer.";
            }

            $is_sent[$i] = $this->sendEmail($destinataire, $sujet, $destinataire->replacePlaceholders($htmlContent), $message);
        }

        return $is_sent;
    }

    public function sendEmail($destinataire, $sujet, $htmlContent, $message = null, $parent_id = null) 
    {
        // parent_id pour les cmd automatisées
        if($parent_id == null) $user = \Auth::user();
        else $user = User::find($parent_id);

        $is_sent = false;
        $sujet = $this->replaceSubjectVariables($sujet);

        try {
            $newEmail = new JournalEmail();
            $newEmail->id_modele = 1;
            $newEmail->id_destinataire = $destinataire->id;
            $newEmail->email_destinataire = $destinataire->email;
            $newEmail->sujet_journal = $sujet;
            $newEmail->corps_journal = $htmlContent;
            $newEmail->parent_id = $user->parentId();
            $newEmail->date_envoi = Carbon::now('America/Toronto');

            if($message != null) 
            {
                $newEmail->statut_journal = 'Echec';
                $newEmail->raison_echec = $message;
            }
            else if (strpos($htmlContent, '#NULL#') === false) {
                Mail::to($destinataire->email)->send(new CitadelleEmail($sujet, $htmlContent));
                $newEmail->statut_journal = 'Envoyé';
                $newEmail->raison_echec = "Email envoyé avec succès.";
                $is_sent = true;
            } else {
                $newEmail->statut_journal = 'Echec';
                $newEmail->raison_echec = "L'email contient des valeurs invalides.";
            }

            $newEmail->save();
            return $is_sent;
            
        } catch (\Exception $e) {
            $this->handleException($destinataire, $sujet, $htmlContent, $e->getMessage());
        }
    }

    private function handleException($destinataire, $sujet, $htmlContent, $errorMessage)
    {
        $user = \Auth::user();

        Log::error('Failed to send email: ' . $errorMessage);

        $newEmail = new JournalEmail();
        $newEmail->id_modele = 1;
        $newEmail->id_destinataire = $destinataire->id;
        $newEmail->email_destinataire = $destinataire->email;
        $newEmail->sujet_journal = $sujet;
        $newEmail->corps_journal = $htmlContent;
        $newEmail->parent_id = $user->parentId();
        $newEmail->date_envoi = now();
        $newEmail->raison_echec = $errorMessage;
        $newEmail->statut_journal = 'Échec';

        $newEmail->save();

        throw new \Exception('Failed to send email. Error: ' . $errorMessage);
    }
}
