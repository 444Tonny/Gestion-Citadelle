<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    public function index()
    {
        try {

            $user = \Auth::user();

            if (\Auth::user()->can('manage templates')) 
            {
                $emailTemplates = EmailTemplate::all();

                if(\Auth::user()->type=='tenant'){
                }

                return view('template.index', compact('emailTemplates'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied!'));
            }

        } catch (\Throwable $th) {

            $th->getMessage();
            //dd($th);
            return redirect()->back()->with('error', __($th));
        }
    }

    public function create()
    {
        try {
            return view('template.create');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function store(Request $request)
    {
        try {
            if (\Auth::user()->can('manage templates')) {
                $validator = \Validator::make(
                    $request->all(), [
                        'nom_modele' => 'required',
                        'sujet' => 'required',
                        'corps_code' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $template = new EmailTemplate();
                $template->nom_modele = $request->nom_modele;
                $template->categorie_modele = $request->sujet;
                $template->sujet = $request->sujet;
                $template->corps = mb_convert_encoding(base64_decode($request->corps_code), 'UTF-8', 'ISO-8859-1');
                $template->parent_id = \Auth::user()->parentId();
                $template->save();

                return redirect()->route('template.index')->with('success', __('Email Template successfully created.'));
            } else 
            {    
                return redirect()->back()->with('error', __('Permission Denied!'));
            }
        } 
        catch (\Throwable $th) {
            //dd($th);
            return redirect()->back()->with('error', __($th->getMessage()));
        }
    }

    public function edit(EmailTemplate $template)
    {
        if (\Auth::user()->can('manage templates')) {
            
            return view('template.edit', compact('template'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function update(Request $request, EmailTemplate $template)
    {
        if (\Auth::user()->can('manage templates')) {
            $validator = \Validator::make(
                $request->all(), [
                    'nom_modele' => 'required',
                    'sujet' => 'required',
                    'corps_code' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $template->nom_modele = $request->nom_modele;
            $template->categorie_modele = $request->sujet;
            $template->sujet = $request->sujet;
            $template->corps = mb_convert_encoding(base64_decode($request->corps_code), 'UTF-8', 'ISO-8859-1');
            $template->save();

            return redirect()->route('template.index')->with('success', __('Email Template successfully updated.'));
        } 
        else 
        {    
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function destroy($id)
    {

        if(\Auth::user()->can('manage emails'))
        {
            $role = EmailTemplate::find($id);
            $role->delete();

            return redirect()->back()->with('success', 'Template successfully deleted!');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

    }
}
