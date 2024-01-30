<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected function schedule(Schedule $schedule)
    {
        $triggers = DB::table('automation_triggers')->where('is_active', 'enabled')->get();
    
        foreach ($triggers as $trigger) {
            $command = "emails:send {$trigger->recipients} {$trigger->id_modele} {$trigger->parent_id}";
            $expression = $trigger->scheduling_expression;
            $timezone = $trigger->timezone;
        
            // Récupérez le jour du mois à partir de l'expression cron
            $dayOfMonth = explode(' ', $expression)[2];
        
            // Vérifiez si le jour du mois est valide pour le mois actuel
            if ($dayOfMonth == '*' || ($dayOfMonth > 0 && $dayOfMonth <= date('t'))) 
            {
                echo "Tâche planifiée: $command avec expression cron $expression" . PHP_EOL;
                $schedule->command($command)->timezone($timezone)->cron($expression);
                //$schedule->command($command)->cron('*/3 * * * *');
            } 
            else 
            {
                // Remplacez le jour du mois par le dernier jour du mois
                $lastDayOfMonth = date('t');
                $expression = implode(' ', array_slice(explode(' ', $expression), 0, 2)) . " $lastDayOfMonth * *";
        
                echo "Tâche planifiée (avec jour du mois ajusté): $command avec expression cron $expression" . PHP_EOL;
                $schedule->command($command)->timezone($timezone)->cron($expression);
                //$schedule->command($command)->cron('*/3 * * * *');
            }
        }

        $rentTriggers = DB::table('rent_triggers')->where('is_active', 'enabled')->get();
    
        foreach ($rentTriggers as $rentTrigger) {
            $command = "emails:send {$rentTrigger->recipients} {$rentTrigger->id_modele} {$rentTrigger->parent_id}";
            $expression = $rentTrigger->scheduling_expression;
            $timezone = $rentTrigger->timezone;
        
            // Récupérez le jour du mois à partir de l'expression cron
            $dayOfMonth = explode(' ', $expression)[2];
        
            // Vérifiez si le jour du mois est valide pour le mois actuel
            if ($dayOfMonth == '*' || ($dayOfMonth > 0 && $dayOfMonth <= date('t'))) 
            {
                echo "Tâche planifiée: $command avec expression cron $expression" . PHP_EOL;
                $schedule->command($command)->timezone($timezone)->cron($expression);
                //$schedule->command($command)->cron('*/3 * * * *');
            } 
            else 
            {
                // Remplacez le jour du mois par le dernier jour du mois
                $lastDayOfMonth = date('t');
                $expression = implode(' ', array_slice(explode(' ', $expression), 0, 2)) . " $lastDayOfMonth * *";
        
                echo "Tâche planifiée (avec jour du mois ajusté): $command avec expression cron $expression" . PHP_EOL;
                $schedule->command($command)->timezone($timezone)->cron($expression);
                //$schedule->command($command)->cron('*/3 * * * *');
            }
        }
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
