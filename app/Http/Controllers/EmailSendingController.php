<?php

namespace App\Http\Controllers;

use App\Models\TenantInvoice;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\User;
use App\Models\PropertyUsers;
use App\Models\JournalEmail;
use App\Services\EmailService;

class EmailSendingController extends Controller
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function index()
    {
        try 
        {
            if (\Auth::user()->can('manage emails')) 
            {
                $user = \Auth::user();

                $journauxEmail = JournalEmail::where('parent_id', '=', $user->parentId())
                    ->orderBy('date_envoi', 'desc')
                    ->get();

                //dd($journauxEmail);

                return view('emails.index', compact('journauxEmail'));
            } 
            else {
                return redirect()->back()->with('error', __('Permission Denied!'));
            }

        } 
        catch (\Throwable $th) 
        {
            $th->getMessage();
            return redirect()->back()->with('error', __($th));
        }
    }

    public function show($idJournal)
    {
        $journal = JournalEmail::find($idJournal);

        return view('emails.show', compact('journal'));
    }


    public function chooseType()
    {
        $templates = EmailTemplate::where('parent_id', '=', \Auth::user()->parentId())->pluck('nom_modele', 'id_modele');

        return view('emails.typeForm', compact('templates'));
    }


    public function prepareSend(Request $request)
    {
        try {
            $user = \Auth::user();

            $template = EmailTemplate::where('id_modele', '=', $request->input('template'))->get();
            //$users = User::where('parent_id', '=', $user->parentId())->orderBy('email', 'asc') ->get();

            $users = User::leftJoin('property_tenant_user_view', 'users.id', '=', 'property_tenant_user_view.id_user')
                    ->where('users.parent_id', '=', $user->parentId())
                    ->select('users.*', 'property_tenant_user_view.name as property_name')
                    ->get();

            $properties = PropertyUsers::where('parent_id', $user->parentId())
                    ->groupBy('name')
                    ->pluck('name')
                    ->toArray();

            if($request->input('submitType') == 'single') return view('emails.createSingle', compact('template', 'users'));
            else if($request->input('submitType') == 'group') return view('emails.createGroup', compact('template', 'users', 'properties'));
            else return view('emails.createAuto', compact('template', 'users'));

        } catch (\Throwable $th) {
            
            dd($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    // Voir un aperçu de l'email avant de confirmer l'insertion et envoi
    public function store(Request $request)
    {   
        $destinataire = TenantInvoice::find($request->input('destinataire'));

        if($destinataire == null) $destinataire = User::find($request->input('destinataire'));

        $destinatairePlaceholder = $destinataire->email;
        $destinataireId = $destinataire->id;

        $contenuMail = $request->input('corps_code');
        $sujet = $this->emailService->replaceSubjectVariables($request->input('sujet'));

        // Remplacer les variables entre accolades
        $texteHtmlRemplace = $destinataire->replacePlaceholders(mb_convert_encoding(base64_decode($contenuMail), 'UTF-8', 'ISO-8859-1'));

        // Encoder une fois que les variables sont remplacées
        $contenuMail = base64_encode(mb_convert_encoding($texteHtmlRemplace, 'ISO-8859-1', 'UTF-8'));

        return view('emails.preview', compact('contenuMail', 'sujet', 'destinatairePlaceholder', 'destinataireId'));
    }


    // Confirm single email sending
    public function sendSingleEmail(Request $request)
    {
        try {
            $destinataire = User::find($request->input('destinataire'));
            $sujet = $this->emailService->replaceSubjectVariables($request->input('sujet'));
            $htmlContent = mb_convert_encoding(base64_decode($request->input('contenuMail')), 'UTF-8', 'ISO-8859-1');

            $is_sent = $this->emailService->sendEmail($destinataire, $sujet, $htmlContent);
            
            if($is_sent == true) return redirect()->route('emails.index')->with('success', "Email envoyé avec succès");
            else return redirect()->route('emails.index')->with('error', "L'email contient des valeurs invalides.");

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function sendGroup(Request $request)
    {
        try 
        {
            $selectedUsers = $request->input('selectedUsers');

            $sujet = $this->emailService->replaceSubjectVariables($request->input('sujet'));
            $htmlContent = mb_convert_encoding(base64_decode($request->input('corps_code')), 'UTF-8', 'ISO-8859-1');
    
            $is_sent = $this->emailService->sendMassEmail($selectedUsers, $sujet, $htmlContent);

            // Vérifiez si au moins un e-mail n'a pas été envoyé
            if (in_array(false, $is_sent, true)) {
                return redirect()->route('emails.index')->with('error', 'Echec de certains envois.');
            } else {
                return redirect()->route('emails.index')->with('success', 'Tous les emails ont été envoyés avec succès.');
            }

        } 
        catch (\Throwable $th) 
        {
            return redirect()->route('emails.index')->with('error', 'Echec de certains envois.');
        }
    }

    public function destroy($id)
    {
        $journal = JournalEmail::find($id);
        $journal->delete();

        return redirect()->back()->with('success', 'Email successfully deleted');
    }
}

