<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{

    public function index()
    {
        $permissions = Permission::all();

        return view('permission.index')->with('permissions', $permissions);
    }


    public function create()
    {

        $roles = Role::get();
//        $roles = Role::where('parent_id', '=', \Auth::user()->parentId())->get();

        return view('permission.create')->with('roles', $roles);
    }


    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $name             = $request['name'];
        $permission       = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();

        if(!empty($request['roles']))
        {
            foreach($roles as $role)
            {
                $r          = Role::where('id', '=', $role)->firstOrFail();
                $permission = Permission::where('name', '=', $name)->first();
                $r->givePermissionTo($permission);
            }
        }

        return redirect()->back()->with('success', 'Permission successfully created!');

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $permission = Permission::find($id);
        $roles      = Role::where('parent_id', '=', \Auth::user()->parentId())->get();

        return view('permission.edit', compact('roles', 'permission'));
    }


    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $validator  = \Validator::make(
            $request->all(), [
                               'name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $input = $request->all();
        $permission->fill($input)->save();

        return redirect()->back()->with('success', 'Permission successfully updated!');
    }


    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->back()->with('success', 'Permission successfully deleted!');
    }
}
