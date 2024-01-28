<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailAutomationService;
use App\Services\EmailService;
use App\Models\TenantInvoice;
use App\Models\User;
use App\Models\AutomationTrigger;
use App\Models\RentTrigger;
use App\Models\EmailTemplate;
use App\Models\PropertyUsers;

class RentAutomationController extends Controller
{    
    protected $cronService;    
    private $emailService;

    public function __construct(EmailAutomationService $cronService, EmailService $emailService)
    {
        $this->cronService = $cronService;
        $this->emailService = $emailService;
    }

    public function index()
    {
        try 
        {
            $parentId = \Auth::user()->parentId();
            $triggers = RentTrigger::where('parent_id', '=', $parentId)->get();

            if ($triggers->count() > 0) {
                // Transformez les expressions cron en phrases lisible
                $triggers->transform(function ($trigger) {
                    $trigger->readableExpression = $this->cronService->cronExpressionToReadable($trigger->scheduling_expression);
                    return $trigger;
                });
            }

            return view('rentAuto.index', compact('triggers'));
        } 
        catch (\Throwable $th) 
        {
            $th->getMessage();
            return redirect()->back()->with('error', __($th));
        }
    }

    // Afficher les destinataires et details d'une tâche
    public function showTaskDetails($idTrigger)
    {
        $user = \Auth::user();
        $trigger = RentTrigger::find($idTrigger);

        $recipients = $this->cronService->convertIDStringToUsers($trigger->recipients);
        

        $otherUsers = User::where('parent_id', $user->parentId())
            ->whereNotIn('id', $recipients->pluck('id')->toArray())
            ->orderBy('email', 'asc')
            ->get();

        return view('rentAuto.show', compact('trigger','recipients', 'otherUsers'));
    }

    public function chooseTemplate()
    {
        $templates = EmailTemplate::where('parent_id', '=', \Auth::user()->parentId())->pluck('nom_modele', 'id_modele');

        return view('rentAuto.chooseTemplate', compact('templates'));
    }

    public function showAutoForm(Request $request)
    {
        try {
            $user = \Auth::user();

            $template = EmailTemplate::where('id_modele', '=', $request->input('template'))->get();

            $users = User::leftJoin('property_tenant_user_view', 'users.id', '=', 'property_tenant_user_view.id_user')
                        ->where('users.parent_id', '=', $user->parentId())
                        ->select('users.*', 'property_tenant_user_view.name as property_name')
                        ->get();

            // Récuperer toutes les propriété de l'utilisateur
            $properties = PropertyUsers::where('parent_id', $user->parentId())
                            ->groupBy('name', 'id_property')
                            ->pluck('name', 'id_property')
                            ->toArray();

            return view('rentAuto.createAuto', compact('template', 'users', 'properties'));

        } catch (\Throwable $th) {
            
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $user = \Auth::user();

            $validator = \Validator::make(
                $request->all(), [
                    'name_task' => 'required',
                    'interval' => 'required',
                    'time' => 'required',
                    'sujet' => 'required',
                    'timezone' => 'required'
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route('rentAuto.index')->with('error', 'Champs insuffisant.');
            }
    
            // Récupérer les données du formulaire
            $time = $request->input('time');
            $dayOfMonth = $request->input('dayOfMonth', '*');
            $month = $request->input('month', '*');
            $dayOfWeek = $request->input('day', '*');
    
            // Générez l'expression cron en fonction des données du formulaire
            $cronExpression = $this->cronService->generateCronExpression($time, $dayOfMonth, $month, $dayOfWeek);
    
            // Créez une nouvelle instance de AutomationTrigger dans la base de données
            $automationTrigger = new RentTrigger();
            $automationTrigger->scheduling_expression = $cronExpression;
            $automationTrigger->name_task = $request->input('name_task');
            $automationTrigger->type = $this->emailService->replaceSubjectVariables($request->input('sujet'));
            $automationTrigger->frequence = $request->input('interval');
            $automationTrigger->id_modele = $request->input('id_modele');
            $automationTrigger->is_active = 'enabled';
            $automationTrigger->recipients = implode(',', $request->input('recipients')); // id de la propriété des recipients
            $automationTrigger->parent_id = \Auth::user()->parentId();
            $automationTrigger->timezone = $request->input('timezone');
            $automationTrigger->save();
    
            return redirect()->route('rentAuto.index')->with('success', 'Email automatique créé avec succès!');

        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('rentAuto.index')->with('error', 'An error occured');
        }
    }
    
    public function deleteRecipient($id, $triggerId)
    {
        try
        {
            $trigger = RentTrigger::find($triggerId);

            $trigger->recipients = $this->cronService->deleteIDFromString($trigger->recipients, $id);
            $trigger->save();
    
            return response()->json(['success' => 'User deleted successfully.']);
        }
        catch(\Exception $th)
        {
            echo($th);
            return response()->json(['error' => 'An error occured:' .$th]);
        }
    }

    public function addRecipient($id, $triggerId)
    {
        try
        {
            $trigger = RentTrigger::find($triggerId);

            $trigger->recipients = $this->cronService->addIDToString($trigger->recipients, $id);
            $trigger->save();

            $user = User::find($id);
    
            return response()->json([
                'success' => true,
                'email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ]);
        }
        catch(\Exception $th)
        {
            echo($th);
            return response()->json(['error' => 'An error occured:' .$th]);
        }
    }

    public function destroy($id)
    {
        $trigger = RentTrigger::find($id);
        $trigger->delete();

        return redirect()->back()->with('success', 'Trigger successfully deleted');
    }

    public function updateState(Request $request)
    {
        $newActiveState = $request->input('newActiveState');
        $idCheckbox = $request->input('idCheckbox');

        // Supposons que votre modèle Trigger a une colonne 'is_active'
        // que vous souhaitez mettre à jour
        $trigger = RentTrigger::find($idCheckbox); // Remplacez 1 par l'ID de votre trigger

        if ($trigger) {
            $trigger->is_active = $newActiveState;
            $trigger->save();

            return response()->json(['message' => 'État du trigger mis à jour avec succès']);
        }

        return response()->json(['message' => 'Erreur lors de la mise à jour de l\'état du trigger'], 500);
    }
}
