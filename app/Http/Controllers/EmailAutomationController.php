<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailService;
use App\Models\TenantInvoice;
use App\Models\AutomationTrigger;

class EmailAutomationController extends Controller
{
    public function sendAuto(Request $request)
    {
        try {
            $validator = \Validator::make(
                $request->all(), [
                    'selectedUsers' => 'required',
                    'interval' => 'required',
                    'time' => 'required',
                    'dayOfMonth' => 'required',
                    'sujet' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->view('emails.index')->with('error', $messages->first());
            }
    
            // Récupérer les données du formulaire
            $time = $request->input('time');
            $dayOfMonth = $request->input('dayOfMonth');
            $month = $request->input('month', '*');
            $dayOfWeek = $request->input('dayOfWeek', '*');
    
            // Générez l'expression cron en fonction des données du formulaire
            $cronExpression = $this->generateCronExpression($time, $dayOfMonth, $month, $dayOfWeek);
    
            // Créez une nouvelle instance de AutomationTrigger dans la base de données
            $automationTrigger = new AutomationTrigger();
            $automationTrigger->scheduling_expression = $cronExpression;
            $automationTrigger->type = $request->input('sujet');
            $automationTrigger->frequence = $request->input('interval');
            $automationTrigger->id_modele = $request->input('id_modele');
            $automationTrigger->recipients = implode(',', $request->input('selectedUsers')); //reverse $array = explode(', ', $string);
            $automationTrigger->save();
    
            return redirect()->route('emails.index')->with('success', 'Automation Trigger créé avec succès!');

        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('emails.index')->with('error', 'An error occured');
        }
    }

    private function generateCronExpression($time, $dayOfMonth, $month, $dayOfWeek)
    {
        // Déterminez la partie minute à partir de l'heure
        list($hour, $minute) = explode(':', $time);
        $minutePart = $minute;

        // Initialisez les parties de l'expression cron avec des valeurs par défaut
        $minutePart = $minute ?? '0';
        $hourPart = $hour ?? '*';
        $dayOfMonthPart = $dayOfMonth ?? '*';
        $monthPart = $month ?? '*';
        $dayOfWeekPart = $dayOfWeek ?? '*';

        $cronExpression = "$minutePart $hourPart $dayOfMonthPart $monthPart $dayOfWeekPart";

        return $cronExpression;
    }
}
