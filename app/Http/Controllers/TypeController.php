<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage types')) {
            $types = Type::where('parent_id', \Auth::user()->parentId())->get();
            return view('type.index', compact('types'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function create()
    {
        $types = Type::$types;
        return view('type.create', compact('types'));
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create types')) {
            $validator = \Validator::make(
                $request->all(), [
                'title' => 'required|regex:/^[\s\w-]*$/',
                'type' => 'required',

            ], [
                    'regex' => __('The Title format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $type = new Type();
            $type->title = $request->title;
            $type->type = $request->type;
            $type->parent_id = \Auth::user()->parentId();
            $type->save();

            return redirect()->back()->with('success', __('Type successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function show(Type $type)
    {
        //
    }


    public function edit(Type $type)
    {

        $types = Type::$types;
        return view('type.edit', compact('types', 'type'));
    }


    public function update(Request $request, Type $type)
    {
        if (\Auth::user()->can('edit types')) {
            $validator = \Validator::make(
                $request->all(), [
                'title' => 'required|regex:/^[\s\w-]*$/',
                'type' => 'required',

            ], [
                    'regex' => __('The Title format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $type = new Type();
            $type->title = $request->title;
            $type->type = $request->type;
            $type->parent_id = \Auth::user()->parentId();
            $type->save();

            return redirect()->back()->with('success', __('Type successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function destroy(Type $type)
    {
        if (\Auth::user()->can('delete types')) {
            $type->delete();
            return redirect()->back()->with('success', 'Type successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }
}
