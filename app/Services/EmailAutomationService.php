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

class EmailAutomationService
{

    function cronExpressionToReadable($cronExpression)
    {
        $parts = explode(' ', $cronExpression);
    
        // Traitement de chaque partie de l'expression cron
        $minute = $this->convertPartToPhrase($parts[0], 'minute');
        $hour = $this->convertPartToPhrase($parts[1], 'heure');
        $dayOfMonth = $this->convertPartToPhrase($parts[2], 'jour du mois');
        $month = $this->convertPartToPhrase($parts[3], 'mois');
    
        // Construction de la phrase
        $phrase = "À $hour:$minute, le $dayOfMonth $month";
    
        return $phrase;
    }
    
    private function convertPartToPhrase($part, $unit)
    {
        if ($part === '*') {
            return "chaque $unit";
        } elseif (strpos($part, ',') !== false) {
            // Gestion des listes (ex. "1,15,30")
            $values = explode(',', $part);
            return implode(', ', array_map(function ($value) use ($unit) {
                return "$value $unit";
            }, $values));
        } elseif (strpos($part, '-') !== false) {
            // Gestion des plages (ex. "1-5")
            list($start, $end) = explode('-', $part);
            return "de $start à $end $unit";
        } elseif (strpos($part, '/') !== false) {
            // Gestion des intervalles (ex. "*/15")
            list($start, $interval) = explode('/', $part);
            return "chaque $interval $unit à partir de $start";
        }
    
        return $part;
    }   
    
    
    public function generateCronExpression($time, $dayOfMonth, $month, $dayOfWeek)
    {
        // Déterminez la partie minute à partir de l'heure
        list($hour, $minute) = explode(':', $time);
        $minutePart = $minute;
    
        // Initialisez les parties de l'expression cron avec des valeurs par défaut
        $minutePart = $minute ?? '0';
        $hourPart = $hour ?? '*';
        $dayOfMonthPart = $dayOfMonth ?? '*';
    
        // Convertissez les tableaux en chaînes pour l'expression cron
        $monthPart = $this->convertArrayToCronPart($month);
        $dayOfWeekPart = $this->convertArrayToCronPart($dayOfWeek);
    
        $cronExpression = "$minutePart $hourPart $dayOfMonthPart $monthPart $dayOfWeekPart";
    
        return $cronExpression;
    }
    
    private function convertArrayToCronPart($array)
    {
        
        if (!is_array($array)) {
            return $array;
        }
        else if (empty($array) || in_array('*', $array)) {
            return '*';
        } else {
            return implode(',', $array);
        }
    }
}

?>