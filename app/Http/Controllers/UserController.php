<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $user = \Auth::user();
        if (\Auth::user()->type == 'super admin') {
            $users = User::where('parent_id', '=', $user->parentId())->where('type', '=', 'admin')->get();
        } else {
            if (\Auth::user()->can('manage user')) {
                $users = User::where('parent_id', '=', $user->parentId())->get();
            } else {
                return redirect()->back()->with('error', __('Permission Denied!'));
            }
        }

        return view('user.index', compact('users'));
    }


    public function create()
    {

        $roles = Role::where('parent_id', '=', \Auth::user()->parentId())->get()->pluck('name', 'id');

        return view('user.create', compact('roles'));
    }


    public function store(Request $request)
    {

        if (\Auth::user()->type == 'super admin') {
            $validator = \Validator::make(
                $request->all(), [
                'name' => 'required|regex:/^[\s\w-]*$/',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ], [
                    'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $user = new User();
            $user->first_name = $request->name;
            $user->email = $request->email;
            $user->password = \Hash::make($request->password);
            $user->type = 'admin';
            $user->lang = 'english';
            $user->profile = 'avatar.png';
            $user->subscription = 1;
            $user->parent_id = \Auth::user()->parentId();
            $user->save();

            $role_r = Role::findByName('owner');
            $user->assignRole($role_r);

            return redirect()->route('users.index')->with('success', __('Organization admin successfully created!'));
        } else {
            if (\Auth::user()->can('create user')) {
                $validator = \Validator::make(
                    $request->all(), [
                    'first_name' => 'required|regex:/^[\s\w-]*$/',
                    'last_name' => 'required|regex:/^[\s\w-]*$/',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6',
                    'role' => 'required',
                ], [
                        'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $authUser = \Auth::user();
                $total_user = $authUser->totalUser();
                $subscription = Subscription::find($authUser->subscription);
                // if ($total_user < $subscription->total_user || $subscription->total_user == 0) {
                    $role_r = Role::findById($request->role);
                    $user = new User();
                    $user->first_name = $request->first_name;
                    $user->last_name = $request->last_name;
                    $user->email = $request->email;
                    $user->phone_number = $request->phone_number;
                    $user->password = \Hash::make($request->password);
                    $user->type = $role_r->name;
                    $user->profile = 'avatar.png';
                    $user->lang = 'english';
                    $user->parent_id = \Auth::user()->parentId();
                    $user->save();

                    $user->assignRole($role_r);
                
                    return redirect()->route('users.index')->with('success', __('User successfully created!'));
                /*
                } else {
                    return redirect()->back()->with('error', __('Your user limit is over, Please upgrade your subscription.'));
                }
                */
            } else {
                return redirect()->back()->with('error', __('Permission Denied!'));
            }
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::where('parent_id', '=', \Auth::user()->parentId())->get()->pluck('name', 'id');

        return view('user.edit', compact('user', 'roles'));
    }


    public function update(Request $request, $id)
    {
        if (\Auth::user()->type == 'super admin') {
            $user = User::findOrFail($id);

            $validator = \Validator::make(
                $request->all(), [
                'name' => 'required|regex:/^[\s\w-]*$/',
                'email' => 'required|email|unique:users,email,' . $id,
            ], [
                    'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $input = $request->all();
            $input['first_name']= $input['name'];

            $user->fill($input)->save();

            return redirect()->route('users.index')->with('success', 'User successfully updated!');
        } else {

            if (\Auth::user()->can('edit user')) {

                $validator = \Validator::make(
                    $request->all(), [
                    'first_name' => 'required|regex:/^[\s\w-]*$/',
                    'last_name' => 'required|regex:/^[\s\w-]*$/',
                    'email' => 'required|email|unique:users,email,' . $id,
                    'role' => 'required',
                ], [
                        'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }


                $role = Role::findById($request->role);
                $user = User::findOrFail($id);
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone_number = $request->phone_number;
                $user->email = $request->email;
                $user->type = $role->name;
                $user->save();

                $user->assignRole($role);

                return redirect()->route('users.index')->with('success', 'User successfully updated!');
            } else {
                return redirect()->back()->with('error', __('Permission Denied!'));
            }

        }
    }


    public function destroy($id)
    {

        if (\Auth::user()->can('delete user') || \Auth::user()->type == 'super admin') {
            $user = User::find($id);
            $user->delete();

            return redirect()->route('users.index')->with('success', __('User successfully deleted!'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }
}
