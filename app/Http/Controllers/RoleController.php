<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('manage role'))
        {

            $roles = Role::where('parent_id', '=', \Auth::user()->parentId())->get();

            return view('role.index', compact('roles'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

    }


    public function create()
    {
        if(\Auth::user()->type == 'super admin')
        {
            $permissions = Permission::all()->pluck('name', 'id')->toArray();

        }
        else
        {
            $permissions = new Collection();
            foreach(\Auth::user()->roles as $role)
            {
                $permissions = $permissions->merge($role->permissions);
            }
            $permissions = $permissions->pluck('name', 'id')->toArray();
        }

        return view('role.create', compact('permissions'));
    }


    public function store(Request $request)
    {

        if(\Auth::user()->can('create role'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|unique:roles,name,NULL,id,parent_id,' . \Auth::user()->parentId(),
                                   'permissions' => 'required',
                               ],[
                    'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $name             = $request['name'];
            $role             = new Role();
            $role->name       = $name;
            $role->parent_id = \Auth::user()->parentId();
            $permissions      = $request['permissions'];
            $role->save();

            foreach($permissions as $permission)
            {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }

            return redirect()->back()->with('success', __('Role successfully created!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }


    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $user = \Auth::user();
        $role = Role::find($id);
        if($user->type == 'super admin')
        {
            $permissions = Permission::all()->pluck('name', 'id')->toArray();
        }
        else
        {
            $permissions = new Collection();
            foreach($user->roles as $role1)
            {
                $permissions = $permissions->merge($role1->permissions);
            }
            $permissions = $permissions->pluck('name', 'id')->toArray();
        }


        return view('role.edit', compact('role','permissions'));
    }


    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit role'))
        {

            $role = Role::find($id);

            if($role->name != 'tenant' && $role->name != 'maintainer'){
                $validator = \Validator::make(
                    $request->all(), [

                    'name' => 'required|regex:/^[\s\w-]*$/|unique:roles,name,' . $role['id'] . ',id,parent_id,' . \Auth::user()->parentId(),
                    'permissions' => 'required',
                ],[
                        'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                    ]
                );
            }else{
                $validator = \Validator::make(
                    $request->all(), [

                    'permissions' => 'required',
                ],[
                        'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                    ]
                );
            }


            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $input       = $request->except(['permissions']);
            $permissions = $request['permissions'];
            $role->fill($input)->save();

            $p_all = Permission::all();

            foreach($p_all as $p)
            {
                $role->revokePermissionTo($p);
            }

            foreach($permissions as $permission)
            {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }

            return redirect()->back()->with('success', __('Role successfully updated!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function destroy($id)
    {

        if(\Auth::user()->can('delete role'))
        {
            $role = Role::find($id);
            $role->delete();

            return redirect()->back()->with('success', 'Role successfully deleted!');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

    }


}
