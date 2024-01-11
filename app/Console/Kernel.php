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
        $triggers = DB::table('automation_triggers')->get();
    
        foreach ($triggers as $trigger) {
            $command = "emails:send {$trigger->recipients} {$trigger->id_modele}";
            $expression = $trigger->scheduling_expression;
        
            // Récupérez le jour du mois à partir de l'expression cron
            $dayOfMonth = explode(' ', $expression)[2];
        
            // Vérifiez si le jour du mois est valide pour le mois actuel
            if ($dayOfMonth == '*' || ($dayOfMonth > 0 && $dayOfMonth <= date('t'))) {
                echo "Tâche planifiée: $command avec expression cron $expression" . PHP_EOL;
                $schedule->command($command)->cron($expression);
            } else {
                // Remplacez le jour du mois par le dernier jour du mois
                $lastDayOfMonth = date('t');
                $expression = implode(' ', array_slice(explode(' ', $expression), 0, 2)) . " $lastDayOfMonth * *";
        
                echo "Tâche planifiée (avec jour du mois ajusté): $command avec expression cron $expression" . PHP_EOL;
                $schedule->command($command)->cron($expression);
            }
        }
        
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
