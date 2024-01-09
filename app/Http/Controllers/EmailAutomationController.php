<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailAutomationService;
use App\Models\TenantInvoice;
use App\Models\User;
use App\Models\AutomationTrigger;
use App\Models\EmailTemplate;

class EmailAutomationController extends Controller
{    
    protected $cronService;

    public function __construct(EmailAutomationService $cronService)
    {
        $this->cronService = $cronService;
    }

    public function index()
    {
        try 
        {
            $triggers = AutomationTrigger::all();

            // Transformez les expressions cron en phrases lisible
            $triggers->transform(function ($trigger) {
                $trigger->readableExpression = $this->cronService->cronExpressionToReadable($trigger->scheduling_expression);
                return $trigger;
            });

            return view('emailsAuto.index', compact('triggers'));
        } 
        catch (\Throwable $th) 
        {
            $th->getMessage();
            return redirect()->back()->with('error', __($th));
        }
    }

    public function chooseTemplate()
    {
        $templates = EmailTemplate::all()->pluck('nom_modele', 'id_modele');

        return view('emailsAuto.newAutoForm', compact('templates'));
    }

    public function showAutoForm(Request $request)
    {
        try {
            $user = \Auth::user();

            $template = EmailTemplate::where('id_modele', '=', $request->input('template'))->get();
            $users = User::where('parent_id', '=', $user->parentId())->get();
            
            return view('emailsAuto.createAuto', compact('template', 'users'));

        } catch (\Throwable $th) {
            
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = \Validator::make(
                $request->all(), [
                    'selectedUsers' => 'required',
                    'interval' => 'required',
                    'time' => 'required',
                    'sujet' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route('emailsAuto.index')->with('error', 'Champs insuffisant: '. $messages);
            }
    
            // Récupérer les données du formulaire
            $time = $request->input('time');
            $dayOfMonth = $request->input('dayOfMonth', '*');
            $month = $request->input('month', '*');
            $dayOfWeek = $request->input('day', '*');
    
            // Générez l'expression cron en fonction des données du formulaire
            $cronExpression = $this->generateCronExpression($time, $dayOfMonth, $month, $dayOfWeek);
    
            // Créez une nouvelle instance de AutomationTrigger dans la base de données
            $automationTrigger = new AutomationTrigger();
            $automationTrigger->scheduling_expression = $cronExpression;
            $automationTrigger->type = $request->input('sujet');
            $automationTrigger->frequence = $request->input('interval');
            $automationTrigger->id_modele = $request->input('id_modele');
            $automationTrigger->is_active = 'Activé';
            $automationTrigger->recipients = implode(',', $request->input('selectedUsers')); //reverse $array = explode(', ', $string);
            $automationTrigger->save();
    
            return redirect()->route('emailsAuto.index')->with('success', 'Email automatique créé avec succès!');

        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('emailsAuto.index')->with('error', 'An error occured');
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
    
        // Convertissez les tableaux en chaînes pour l'expression cron
        $monthPart = $this->convertArrayToCronPart($month);
        $dayOfWeekPart = $this->convertArrayToCronPart($dayOfWeek);
    
        $cronExpression = "$minutePart $hourPart $dayOfMonthPart $monthPart $dayOfWeekPart";
    
        return $cronExpression;
    }
    
    private function convertArrayToCronPart($array)
    {
        if (empty($array)) return '*';
        elseif (!is_array($array)) return $array;
        else return implode(',', $array);
    }
    
    
    public function destroy($id)
    {
        $trigger = AutomationTrigger::find($id);
        $trigger->delete();

        return redirect()->back()->with('success', 'Trigger successfully deleted');
    }
}
